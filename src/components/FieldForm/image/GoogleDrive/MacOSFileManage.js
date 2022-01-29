import { Box, Breadcrumbs, Button, Divider, IconButton, InputAdornment, makeStyles } from '@material-ui/core';
import FolderIcon from '@material-ui/icons/Folder';
import NavigateNextIcon from '@material-ui/icons/NavigateNext';
import { ToggleButton, ToggleButtonGroup } from '@material-ui/lab';
import { MaterialIcon } from 'components';
import ConfirmDialog from 'components/ConfirmDialog';
import DialogCustom from 'components/DialogCustom';
import FieldForm from 'components/FieldForm/FieldForm';
import React from 'react';
import { __ } from 'utils/i18n';
import { useAjax } from 'utils/useAjax';
import FileDetail from './FileDetail';
import FileManagerContext from './FileManagerContext';
import MainColumn from './MainColumn';
import UploadProcessing from './UploadProcessing';

const useStyles = makeStyles((theme) => ({
    root: {
        position: 'relative', minHeight: 'calc( 100vh - 66px )',
        overflow: 'hidden',
        '& > *': {
            WebkitTouchCallout: 'none',
            WebkitUserSelect: 'none',
            KhtmlUserSelect: 'none',
            MozUserSelect: 'none',
            MsUserSelect: 'none',
            userSelect: 'none'
        }
    },
    header: {
        borderBottom: '1px solid ' + theme.palette.dividerDark,
    },
    col1: {
        maxWidth: 200,
        width: 200,
        borderRight: '1px solid ' + theme.palette.dividerDark,
        flexShrink: 0,
    },
    col2: {
        flexGrow: 1,
        borderRight: '1px solid ' + theme.palette.dividerDark,
    },
    col2Header: {
        height: 48,
        padding: '6px 0',
        overflowX: 'auto',
        overflowY: 'hidden',
        '& .MuiBreadcrumbs-ol': {
            flexWrap: 'nowrap',
        },
        '& .MuiButton-root': {
            textTransform: 'inherit',
            fontWeight: 'normal',
            fontSize: 16,
            whiteSpace: 'nowrap',
        }
    },
    col2Dir: {
        height: 'calc( 100vh - 115px)',
        width: '100%',
        overflowY: 'auto',
        overflowX: 'hidden',
        borderRight: '1px solid #dadce0',
    },
    col3: {
        width: 0,
        flexShrink: 0,
        height: 'calc( 100vh - 115px)',
        overflowY: 'auto',
        overflowX: 'hidden',
        transition: 'width .2s',
        '&.open': {
            width: 300,
        }
    },
    filters: {
        '& .MuiToggleButton-root': {
            border: 'none'
        },
        '& .Mui-selected': {
            background: theme.palette.divider
        }
    },
    notShowTrashFile: {
        '& .file-deleted': {
            width: 0, height: 0, position: 'absolute', visibility: 'hidden',
            display: 'none',
        }
    }
}));

function MacOSFileManage({ values, handleSubmit, handleChooseFile, filesActive, ...rest }) {

    const classes = useStyles();

    const ajax1 = useAjax();

    const [resource, setResource] = React.useState(JSON.parse(localStorage.getItem('fileManager')) ?? {
        loaded: false
    });


    const [location, setLocation] = React.useState([]);
    const [fileType, setFileType] = React.useState('all');

    const [search, setSearch] = React.useState({ query: '' });

    const [showFilterFileType, setShowFilterFileType] = React.useState(true);

    const [extensions, setExtensions] = React.useState(false);

    const configrmDialog = React.useState({
        open: false,
        file: null,
    });

    const fileSelected = React.useState({
        open: false,
        file: null,
    });

    const [config, setConfig] = React.useState({
        ...rest.config,
        loaded: false,
    });

    React.useEffect(() => {
        handleOnLoadDir(null, true, 0, true);
    }, []);

    const handleOnLoadDir = React.useCallback((path = null, loadLocation = false, version = 0, loading = true, callback = null) => {

        if (!path) {
            if (resource.path) {
                path = resource.path;
            } else {
                path = 'uploads';
            }
        }

        if (!version) version = resource.version ? (resource.version + 1) : 1;

        ajax1.ajax({
            url: 'file-manager/get',
            loading: loading,
            data: {
                path: path,
                loadLocation: loadLocation,
                version: version
            },
            success: (result) => {

                if (result.files) {

                    setResource(prev => {

                        let breadcrumbs = path.split('/');
                        let breadcrumbsResult = [];

                        for (let index = 0; index < breadcrumbs.length; index++) {

                            let temp = [];

                            for (let i = 0; i < index; i++) {
                                temp.push(breadcrumbs[i]);
                            }
                            temp.push(breadcrumbs[index]);

                            breadcrumbsResult.push({
                                ...result.dataBreadcrumbs[temp.join('/')],
                                title: breadcrumbs[index],
                                path: temp.join('/'),
                                // color: result.dataBreadcrumbs[temp.join('/')]?.color ?? false,
                            })

                        }

                        let resourceTemp = { showInTrash: prev.showInTrash ?? false, template: prev.template ?? 'grid', breadcrumbs: breadcrumbsResult, path: path, files: result.files, version: result.version, loaded: true };

                        return resourceTemp;
                    });
                    fileSelected[1](prev => ({ ...prev, file: null }))
                }

                if (loadLocation && result.location) {
                    setLocation(result.location);
                }

                if (result.config && !config.loaded) {
                    if (rest.fileType) {
                        let extensionsTemp = {};
                        let showFilterFileType = true;
                        let configTemp = {};

                        if (typeof rest.fileType === 'string') {
                            configTemp = { ...config, ...result.config, loaded: true };
                            showFilterFileType = false;
                            extensionsTemp = result.config.extension[rest.fileType];

                        } else if (Array.isArray(rest.fileType)) {

                            if (rest.fileType.length < 2) showFilterFileType = false;

                            result.config.extensionFilter.forEach((item, index) => {
                                if (rest.fileType.indexOf(item.key) === -1) {
                                    delete result.config.extensionFilter[index];
                                } else {
                                    extensionsTemp = { ...extensionsTemp, ...result.config.extension[item.key] };
                                }
                            });

                            configTemp = { ...config, ...result.config, loaded: true };
                        }

                        setExtensions(extensionsTemp);
                        setShowFilterFileType(showFilterFileType);
                        setConfig(configTemp);
                    } else {
                        setConfig({ ...config, ...result.config, loaded: true });
                    }
                }

                if (callback) {
                    callback(result);
                }

                handleSaveLocalStorage('path', path);

            }
        });
    });

    const onDoubleClickDir = React.useCallback((file) => {
        handleOnLoadDir(file.dirpath + '/' + file.basename);
    });
    const onDoubleClickImage = React.useCallback((file) => {
        handleChooseFile(file);
    })
    const onDoubleClickFile = React.useCallback((file) => {
        handleChooseFile(file);
    });

    // const selectionSelected = React.useRef(null);

    // React.useEffect(() => {
    //     selectionSelected.current.scroll({
    //         top: selectionSelected.current.scrollHeight,
    //         behavior: 'smooth'
    //     });
    // }, [filesSelected]);

    const createThumbnailFile = (file) => {
        if (file.is_image) {
            let reader = new FileReader();
            reader.onload = function (e) {
                uploadPropertiFileUpload(file, { thumbnail: this.result });
            };
            reader.readAsDataURL(file);
            file.fileReader = reader;
        } else {
            file.thumbnail = '/admin/fileExtension/ico/' + file.fileNmae.split('.').slice(-1)[0] + '.jpg';
        }

        return file;
    }

    const uploadPropertiFileUpload = (file, properties) => {
        setFilesUpload(prev => {
            let fileUploadTemp = { ...prev, open: true, openContent: true };

            if (!fileUploadTemp.files[file.key]) {
                fileUploadTemp.files[file.key] = createThumbnailFile(file);
            }

            fileUploadTemp.files[file.key] = {
                ...file,
                ...fileUploadTemp.files[file.key],
                ...properties
            };
            return fileUploadTemp;
        });
    }


    const handleOnSubmitRenameFile = () => {
        ajax1.ajax({
            url: 'file-manager/rename',
            data: {
                file: openRenameDialog[0].file,
                origin: openRenameDialog[0].origin,
            },
            success: (result) => {
                if (result.success && openRenameDialog[0].success) {
                    openRenameDialog[0].success(result);
                }
            }
        });
    };


    const [filesUpload, setFilesUpload] = React.useState({
        open: false,
        openContent: true,
        files: {}
    });

    const FileDragDropOnLoadFileUpload = (files) => {

        console.log(files);

        setFilesUpload(prev => {

            let fileUploadTemp = { ...prev };
            files.forEach(item => {
                if (fileUploadTemp.files[item.key]) {
                    ajax1.showNotification('File duplication error');
                } else {
                    item.percentLoaded = 0;
                    item.sizeUpload = item.size;
                    item.fileNmae = item.name;

                    item = createThumbnailFile(item);
                    fileUploadTemp.files[item.key] = item;
                }
            });

            return fileUploadTemp;
        })
    };

    const FileDragDropOnProcesingFile = (file, percent) => {
        uploadPropertiFileUpload(file, {
            percentLoaded: percent
        });
    }

    const FileDragDropUpLoadFileSuccess = (file) => {
        uploadPropertiFileUpload(file, {
            uploadComplete: true
        });
        handleOnLoadDir();
    }

    const FileDragDropUploadFileError = (file, message) => {
        uploadPropertiFileUpload(file, {
            uploadComplete: false,
            message: message,
        });
    }

    const openRenameDialog = React.useState({
        open: false,
        file: {},
        onSubmit: null,
        success: null
    });

    console.log(openRenameDialog[0]);

    const openNewDialog = React.useState({
        open: false,
        file: { filename: 'Untitled folder' },
        folder: null,
        onSubmit: null,
        success: null
    });

    const handleOnSubmitNewFolder = () => {
        ajax1.ajax({
            url: 'file-manager/new-folder',
            data: {
                file: openNewDialog[0].file,
                folder: openNewDialog[0].folder,
            },
            success: (result) => {
                if (result.success && openNewDialog[0].success) {
                    openNewDialog[0].success(result);
                }
            }
        });
    }

    const eventDragDropFile = {
        path: resource.path,
        onLoadFiles: FileDragDropOnLoadFileUpload,
        onProcesingFile: FileDragDropOnProcesingFile,
        upLoadFileSuccess: FileDragDropUpLoadFileSuccess,
        uploadFileError: FileDragDropUploadFileError
    };

    const moveFileOrFolder = (file, folder, success) => {
        if ((file.dirpath + '/' + file.basename) !== (folder.dirpath + '/' + folder.basename)) {
            ajax1.ajax({
                url: 'file-manager/move',
                data: {
                    file: file,
                    folder: folder
                },
                success: (result) => {
                    if (result.success) {
                        success(result);
                    }
                }
            });
        }
    }

    const handleChangeFileType = (e, type) => {
        if (type) {
            setFileType(type);
            setExtensions({ ...config.extension[type] });
        } else {
            if (Array.isArray(rest.fileType)) {

                let extensionsTemp = {};

                config.extensionFilter.forEach((item, index) => {
                    extensionsTemp = { ...extensionsTemp, ...config.extension[item.key] };
                });
                setExtensions({ ...extensionsTemp });
            }

            setFileType('all');
        }
    }

    const handleSaveLocalStorage = (key, value) => {
        let dataCurrent = JSON.parse(localStorage.getItem('fileManager')) ?? {};
        dataCurrent[key] = value;
        localStorage.setItem('fileManager', JSON.stringify(dataCurrent));
    }

    return (
        <FileManagerContext.Provider value={{
            fileSelected: fileSelected,
            openNewDialog: openNewDialog,
            openRenameDialog: openRenameDialog,
            onDoubleClickFile: onDoubleClickFile,
            onDoubleClickDir: onDoubleClickDir,
            onDoubleClickImage: onDoubleClickImage,
            ajax: ajax1,
            configrmDialog: configrmDialog,
            moveFileOrFolder: moveFileOrFolder,
            config: config,
            extensions: extensions,
            search: search,
        }}>
            {
                resource.loaded &&
                <div className={classes.root}>
                    <Box
                        display="flex"
                        width={1}
                        className={classes.root}
                        onDrop={(e) => e.preventDefault()}
                        onDragOver={(e) => e.preventDefault()}
                        onDragLeave={(e) => e.preventDefault()}
                    >
                        <div
                            className={classes.col2 + ' ' + (resource.showInTrash ? '' : classes.notShowTrashFile)}
                        >
                            <Box display="flex" justifyContent="space-between" alignItems="center" className={classes.header}>
                                <Breadcrumbs itemsAfterCollapse={3} itemsBeforeCollapse={2} separator={<NavigateNextIcon fontSize="small" />} className={classes.col2Header + ' custom_scroll'} maxItems={5} aria-label="breadcrumb">
                                    <Button onClick={e => { handleOnLoadDir('uploads', null, resource.version + 1) }}>{__('My File')}</Button>
                                    {
                                        Boolean(resource.breadcrumbs) &&
                                        resource.breadcrumbs.filter((item, index) => index > 0).map((item, index) => (
                                            <Button
                                                key={index}
                                                startIcon={
                                                    <FolderIcon style={{ width: 20, height: 20, color: item.color ? item.color : '#69caf7' }} />
                                                } onClick={e => { handleOnLoadDir(item.path, null, resource.version + 1) }} >
                                                {item.title}
                                            </Button>
                                        ))
                                    }
                                </Breadcrumbs>
                                <Box
                                    display="flex"
                                    alignItems="center"
                                    onClick={() => fileSelected[1](prev => ({ ...prev, file: null }))}
                                >

                                    <IconButton
                                        onClick={() => {
                                            handleSaveLocalStorage('template', resource?.template === 'list' ? 'grid' : 'list');
                                            setResource(prev => ({ ...prev, template: resource?.template === 'list' ? 'grid' : 'list' }))
                                        }}
                                    >
                                        <MaterialIcon icon={resource?.template === 'list' ? 'Apps' : 'ReorderRounded'} />
                                    </IconButton>

                                    <IconButton onClick={() => {
                                        handleSaveLocalStorage('showInTrash', !resource.showInTrash);
                                        setResource(prev => ({ ...prev, showInTrash: !prev.showInTrash }))
                                    }}>
                                        <MaterialIcon icon={resource?.showInTrash ? 'DeleteSweepOutlined' : 'RestoreFromTrashOutlined'} />
                                    </IconButton>

                                    <Divider orientation="vertical" orientation="vertical" flexItem />

                                    {
                                        Boolean(showFilterFileType && config.extensionFilter) &&
                                        <ToggleButtonGroup className={classes.filters} size="medium" value={fileType} exclusive onChange={handleChangeFileType}>
                                            {
                                                config.extensionFilter.map(filterIcon => (
                                                    <ToggleButton key={filterIcon.key} value={filterIcon.key}>
                                                        <MaterialIcon
                                                            icon={fileType === filterIcon.key ? filterIcon.iconActive : filterIcon.icon}
                                                        />
                                                    </ToggleButton>
                                                ))
                                            }
                                        </ToggleButtonGroup>
                                    }
                                    <div style={{ padding: '0 16px' }}>
                                        <FieldForm
                                            compoment="text"
                                            config={{
                                                title: __('Search'),
                                                size: 'small'
                                            }}
                                            post={search}
                                            name="query"
                                            onKeyPress={(e) => {
                                                if (e.key === 'Enter') {
                                                    setSearch({ query: e.target.value })
                                                }
                                            }}
                                            onReview={value => { setSearch({ query: value }) }}
                                        />
                                    </div>
                                </Box>
                            </Box>

                            <Box display="flex">
                                <MainColumn
                                    resource={resource}
                                    handleOnLoadDir={handleOnLoadDir}
                                    filesActive={filesActive}
                                    eventDragDropFile={eventDragDropFile}
                                    className={classes.col2Dir + ' custom_scroll'}
                                    onClick={(e) => {
                                        if (!e.ctrlKey) {
                                            fileSelected[1](prev => ({ ...prev, file: null }))
                                        }
                                    }}
                                />

                                <div className={classes.col3 + ' ' + (fileSelected[0].open ? 'open' : '') + ' custom_scroll'}>
                                    {
                                        fileSelected[0].open &&
                                        <FileDetail
                                            setFileSelected={fileSelected[1]}
                                            fileSelected={fileSelected[0].file}
                                            handleOnLoadDir={handleOnLoadDir}
                                            resource={resource} />
                                    }
                                </div>

                            </Box>
                        </div>
                    </Box >

                    <DialogCustom
                        open={openRenameDialog[0].open}
                        onClose={() => openRenameDialog[1]({ ...openRenameDialog[0], open: false })}
                        title={__('Rename')}
                        action={<>
                            <Button onClick={() => openRenameDialog[1]({ ...openRenameDialog[0], open: false })}>{__('Cancel')}</Button>
                            <Button variant="contained" onClick={handleOnSubmitRenameFile} color="primary">{__('OK')}</Button>
                        </>}
                    >
                        <FieldForm
                            compoment="text"
                            config={{
                                title: __('Name'),
                            }}
                            post={openRenameDialog[0].file}
                            name="filename"
                            onReview={(value) => { }}
                            endAdornment={openRenameDialog[0].file?.extension ? <InputAdornment position="end">.{openRenameDialog[0].file.extension}</InputAdornment> : null}
                        />
                    </DialogCustom>

                    <DialogCustom
                        open={openNewDialog[0].open}
                        onClose={() => openNewDialog[1]({ ...openNewDialog[0], open: false })}
                        title={__('New Folder')}
                        action={<>
                            <Button onClick={() => openNewDialog[1]({ ...openNewDialog[0], open: false })}>{__('Cancel')}</Button>
                            <Button variant="contained" onClick={handleOnSubmitNewFolder} color="primary">{__('OK')}</Button>
                        </>}
                    >
                        <FieldForm
                            compoment="text"
                            config={{
                                title: __('Name'),
                            }}
                            post={openNewDialog[0].file}
                            name="filename"
                            onReview={(value) => { }}
                        />
                    </DialogCustom>

                    <ConfirmDialog
                        open={configrmDialog[0].open}
                        onClose={() => configrmDialog[1](prev => ({ ...prev, open: false }))}
                        onConfirm={() => {
                            ajax1.ajax({
                                url: 'file-manager/delete',
                                data: {
                                    file: configrmDialog[0].file,
                                },
                                success: (result) => {
                                    configrmDialog[0].success(result);
                                }
                            });
                        }}
                    />
                    <UploadProcessing
                        filesUpload={filesUpload}
                        setFilesUpload={setFilesUpload}
                    />
                </div >
            }
            {ajax1.Loading}
        </FileManagerContext.Provider>
    )
}

export default MacOSFileManage