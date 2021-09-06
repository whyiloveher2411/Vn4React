import { Box, Button, InputAdornment, List, ListItem, ListItemIcon, ListItemText, ListSubheader, makeStyles } from '@material-ui/core';
import { FileDragDrop } from 'components';
import DialogCustom from 'components/DialogCustom';
import FieldForm from 'components/FieldForm/FieldForm';
import React from 'react';
import { useAjax } from 'utils/useAjax';
import { onMouseDown, onMouseMove, onMouseUp } from 'utils/useMouseScroll';
import DirColumn from './DirColumn';
import DirColumnSelected from './DirColumnSelected';
import UploadProcessing from './UploadProcessing';

const useStyles = makeStyles((theme) => ({
    root: {
        position: 'relative', minHeight: 'calc( 100vh - 66px )',
        overflow: 'hidden',
    },
    col1: {
        maxWidth: 200,
        width: 200,
        borderRight: '1px solid ' + theme.palette.divider,
        flexShrink: 0,
    },
    col2: {
        flexGrow: 1,
        overflow: 'auto',
        height: 'calc( 100vh - 66px)',
        overflowY: 'hidden',
        cursor: 'grab',
        borderRight: '1px solid ' + theme.palette.divider,
    },
    col2Item: {
        width: 300,
        borderRight: '1px solid ' + theme.palette.divider,
        '&:last-child': {
            borderRight: 'none'
        }
    },
    col3: {
        width: 300,
        flexShrink: 0,
    },
}));

function MacOSFileManage() {

    const classes = useStyles();

    const ajax1 = useAjax({ loadingType: 'custom' });

    const [resource, setResource] = React.useState([]);
    const [location, setLocation] = React.useState([]);
    const [filesSelected, setFilesSelected] = React.useState([]);

    const [config, setConfig] = React.useState([]);

    React.useEffect(() => {
        handleOnLoadDir('uploads', 0, true);
    }, []);

    const handleOnLoadDir = React.useCallback((path, index, loadLocation = false, version = 0, reloadChildren = true) => {

        ajax1.ajax({
            url: 'file-manager/get',
            data: {
                path: path,
                loadLocation: loadLocation,
                version: version
            },
            success: (result) => {

                if (result.files) {

                    setResource(prev => {

                        let resourceTemp = [...prev];
                        resourceTemp[index] = { path: path, files: result.files, version: result.version };

                        if (reloadChildren) {
                            for (let i = index + 1; i < 6; i++) {
                                delete resourceTemp[i];
                            }
                        }

                        return resourceTemp;
                    });

                }

                if (loadLocation && result.location) {
                    setLocation(result.location);
                }

                if (result.config) {
                    setConfig(result.config);
                }
            }
        });
    });

    const onClickDir = React.useCallback((file, index) => {
        handleOnLoadDir(file.dirpath + '/' + file.basename, parseInt(index) + 1);
    });
    const onClickImage = React.useCallback((file) => {
        setFilesSelected(filesSelectedPrev => [...filesSelectedPrev, file]);
    })
    const onClickFile = React.useCallback(() => {
        alert(3);
    });

    const useRefDir = React.useRef(null);
    const selectionSelected = React.useRef(null);
    React.useEffect(() => {
        selectionSelected.current.scroll({
            top: selectionSelected.current.scrollHeight,
            behavior: 'smooth'
        });
    }, [filesSelected]);

    React.useEffect(() => {
        useRefDir.current.scroll({
            left: useRefDir.current.scrollWidth,
            behavior: 'smooth'
        });
    }, [resource]);

    const [filesUpload, setFilesUpload] = React.useState({});

    const onLoadFileUpload = (files) => {
        setFilesUpload(prev => {
            let fileUploadTemp = { ...prev };
            files.forEach(item => {
                if (fileUploadTemp[item.key]) {
                    ajax1.showNotification('File duplication error');
                } else {
                    item.percentLoaded = 0;
                    item.sizeUpload = item.size;
                    item.fileNmae = item.name;

                    item = createThumbnailFile(item);
                    fileUploadTemp[item.key] = item;
                }
            });
            return fileUploadTemp;
        })
    };

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
            let fileUploadTemp = { ...prev };

            if (!fileUploadTemp[file.key]) {
                fileUploadTemp[file.key] = createThumbnailFile(file);
            }

            fileUploadTemp[file.key] = {
                ...file,
                ...fileUploadTemp[file.key],
                ...properties
            };
            return fileUploadTemp;
        });
    }

    const onProcesingFile = (file, percent) => {
        uploadPropertiFileUpload(file, {
            percentLoaded: percent
        });
    }

    const upLoadFileSuccess = (file) => {
        uploadPropertiFileUpload(file, {
            uploadComplete: true
        });
    }

    const uploadFileError = (file, message) => {
        uploadPropertiFileUpload(file, {
            uploadComplete: false,
            message: message,
        });
    }

    const propsFileDragDrop = {
        onLoadFiles: onLoadFileUpload,
        onProcesingFile: onProcesingFile,
        upLoadFileSuccess: upLoadFileSuccess,
        uploadFileError: uploadFileError,
    };

    const handleOnSubmitRenameFile = () => {
        ajax1.ajax({
            url: 'file-manager/rename',
            data: {
                file: openRenameDialog.file,
                origin: openRenameDialog.origin,
            },
            success: (result) => {
                if (result.success && openRenameDialog.success) {
                    openRenameDialog.success(result);
                }
            }
        });
    };

    const [openRenameDialog, setOpenRenameDialog] = React.useState({
        open: false,
        file: {},
        onSubmit: null,
        success: null
    });

    return (
        <div className={classes.root}>
            <Box
                display="flex"
                width={1}
                className={classes.root}
                onDrop={(e) => e.preventDefault()}
                onDragOver={(e) => e.preventDefault()}
                onDragLeave={(e) => e.preventDefault()}
            >
                <div className={classes.col1}>
                    <List
                        component="nav"
                        aria-labelledby="nested-list-subheader"
                        subheader={
                            <ListSubheader component="div">
                                Storage location
                            </ListSubheader>
                        }>
                        {
                            location.map(local => (
                                <ListItem key={local.key} button selected={local.selected === true}>
                                    <ListItemIcon>
                                        <img style={{ width: 24 }} src={local.avatar} />
                                    </ListItemIcon>
                                    <ListItemText primary={local.title} />
                                </ListItem>
                            ))
                        }
                    </List>
                </div>
                <Box
                    ref={useRefDir}
                    display="flex"
                    {...FileDragDrop({
                        path: "uploads",
                        ...propsFileDragDrop
                    })}
                    onMouseUp={(e) => onMouseUp(e, useRefDir.current)}
                    onMouseDown={(e) => onMouseDown(e, useRefDir.current)}
                    onMouseMove={(e) => onMouseMove(e, useRefDir.current)}
                    className={classes.col2 + ' custom_scroll'}
                >
                    {
                        resource.map((dir, index) => (
                            <div key={index} className={classes.col2Item} >
                                <div style={{ height: 'calc( 100vh - 66px )', overflow: 'hidden', overflowY: 'auto' }} className="custom custom_scroll">
                                    <DirColumn
                                        resource={dir}
                                        indexDir={index}
                                        handleOnLoadDir={handleOnLoadDir}
                                        onClickFile={onClickFile}
                                        onClickDir={onClickDir}
                                        onClickImage={onClickImage}
                                        propsFileDragDrop={propsFileDragDrop}
                                        setOpenRenameDialog={setOpenRenameDialog}
                                    />
                                </div>
                            </div>
                        ))
                    }

                    <div className={classes.col2Item} >
                        <div style={{
                            height: 'calc( 100vh - 66px )',
                            display: 'flex',
                            alignItems: 'center',
                            justifyContent: 'center',
                            overflow: 'hidden',
                            overflowY: 'auto'
                        }} className="custom custom_scroll">
                            {ajax1.Loading}
                        </div>
                    </div>
                </Box>
                <div className={classes.col3}>
                    <div style={{ maxHeight: 'calc( 100vh - 66px )', overflow: 'hidden', overflowY: 'auto' }} ref={selectionSelected} className="custom_scroll">
                        <DirColumnSelected files={filesSelected} indexDir={0} onClickDir={() => { }} />
                    </div>
                </div>
            </Box >

            <DialogCustom
                open={openRenameDialog.open}
                onClose={() => setOpenRenameDialog({ ...openRenameDialog, open: false })}
                title="Rename"
                action={<>
                    <Button onClick={() => setOpenRenameDialog({ ...openRenameDialog, open: false })}>Cancel</Button>
                    <Button variant="contained" onClick={handleOnSubmitRenameFile} color="primary">Ok</Button>
                </>}
            >
                <FieldForm
                    compoment="text"
                    config={{
                        title: 'Name',
                    }}
                    post={openRenameDialog.file}
                    name="filename"
                    onReview={(value) => { }}
                    endAdornment={openRenameDialog.file?.extension ? <InputAdornment position="end">.{openRenameDialog.file.extension}</InputAdornment> : null}
                />

            </DialogCustom>

            <UploadProcessing
                filesUpload={filesUpload}
                setFilesUpload={setFilesUpload}
            />
        </div >
    )
}

export default MacOSFileManage