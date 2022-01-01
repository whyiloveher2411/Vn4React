import { Avatar, Box, Button, CardContent, Divider, IconButton, makeStyles, Table, TableBody, TableCell, TableRow, Typography } from '@material-ui/core';
import FolderIcon from '@material-ui/icons/Folder';
import FieldForm from 'components/FieldForm/FieldForm';
import TableEditBar from 'components/TableEditBar';
import TabsCustom from 'components/TabsCustom';
import GradeRoundedIcon from '@material-ui/icons/GradeRounded';
import ClearRoundedIcon from '@material-ui/icons/ClearRounded';
import React from 'react';
import { useAjax } from 'utils/useAjax';

const useStyles = makeStyles((theme) => ({
    root: {
        '& .MuiTableCell-root': {
            borderBottom: 'none'
        }
    },
    isImage: {
        backgroundImage: 'url(/admin/fileExtension/trans.jpg)',
    },
    avatar: {
        backgroundSize: '13px',
        maxWidth: '100%',
        width: 200,
        height: 150,
        backgroundImage: 'url(/admin/fileExtension/trans.jpg)'
    },
    starred: {
        color: 'white',
        position: 'absolute',
        top: '-10px',
        right: '-40px',
        background: '#f4b400',
        lineHeight: '10px',
        transform: 'rotate(45deg)',
        width: '60px',
        paddingTop: '20px',
        transformOrigin: 'top',
        textAlign: 'center',
        '&>svg': {
            transform: 'rotate(30deg)',
        }
    },
    fileName: {
        marginTop: theme.spacing(1),
        '&>p': {
            color: 'rgba(0,0,0,.72)',
            fontWeight: 500,
            fontSize: '13px',
        }
    },
    extension: {
        width: 16,
        height: 16,
        borderRadius: 4
    },
    labelTrash: {
        position: 'absolute',
        left: '50%',
        top: '50%',
        transform: 'translate(-50%, -50%) rotate(49deg)',
        background: '#7777775e',
        lineHeight: '500px',
        width: '500px',
        textAlign: 'center',
        fontSize: '20px',
        color: 'white',
        zIndex: 1,
        textTransform: 'uppercase',
        letterSpacing: '5px',
        textShadow: '1px 2px 5px #1f1f1f'
    }
}));


function FileDetail({ fileSelected, setFileSelected, resource, handleOnLoadDir }) {

    const classes = useStyles();

    const [fileDetail, setFileDetail] = React.useState({
        file: null,
        parent: null
    });

    React.useEffect(() => {

        let fileSelectedTemp = fileSelected;

        if (fileSelectedTemp) {
            let keys = Object.keys(fileSelectedTemp);
            fileSelectedTemp = fileSelectedTemp[keys[keys.length - 1]];
        } else {
            fileSelectedTemp = null;
        }

        if (fileSelectedTemp && !fileSelectedTemp.data) fileSelectedTemp.data = {};

        let fileDetailTemp = fileSelectedTemp;
        let parentTemp = resource.breadcrumbs[resource.breadcrumbs.length - 1];

        if (fileSelectedTemp && parentTemp) {
            if (parentTemp.path === (fileSelectedTemp.dirpath + '/' + fileSelectedTemp.filename)) {
                parentTemp = resource.breadcrumbs[resource.breadcrumbs.length - 2];
            }
        }

        if (!fileSelectedTemp) {
            fileDetailTemp = resource.breadcrumbs[resource.breadcrumbs.length - 1].infoDetail;

            if (resource.breadcrumbs[resource.breadcrumbs.length - 2]) {
                parentTemp = resource.breadcrumbs[resource.breadcrumbs.length - 2];
            } else {
                parentTemp = null;
            }
        }

        setFileDetail({
            file: fileDetailTemp,
            parent: parentTemp
        });

    }, [fileSelected]);




    React.useEffect(() => {
        if (fileDetail.file && fileDetail.parent) {
            if (fileDetail.parent.path !== fileDetail.file.dirpath) {
                setFileSelected(prev => ({ ...prev, file: null }));
            }
        }
    }, [resource.path]);

    const ajax = useAjax();

    const handleChangeDesription = () => {

        ajax.ajax({
            url: 'file-manager/description',
            loading: false,
            data: {
                file: fileDetail.file,
                description: fileDetail.file.data.description
            },
            success: (result) => {
                if (result.success) {
                    handleOnLoadDir();
                }
            }
        });

    }

    if (fileDetail.file) {
        return (
            <div className={classes.root}>
                <Box display="flex" gridGap={16} alignItems="center" justifyContent="space-between" style={{ padding: '20px 8px' }}>
                    {
                        fileDetail.file.is_dir ?
                            <FolderIcon style={{ flexShrink: 0, width: 24, height: 24, color: fileDetail.file.data?.color ? fileDetail.file.data.color : '#69caf7' }} />
                            :
                            <Avatar
                                style={{ width: 24, height: 24, flexShrink: 0, borderRadius: 3 }}
                                variant="square"
                                src={'/admin/fileExtension/ico/' + (fileDetail.file.extension ? fileDetail.file.extension.replace(/[^a-zA-Z0-9]/g, "").toLowerCase() + '.jpg' : 'folder3.png')}
                            />
                    }
                    <Typography variant="h5" style={{ width: '100%' }}>{fileDetail.file.basename}</Typography>
                    <IconButton style={{ flexShrink: 0 }} onClick={() => { setFileSelected(prev => ({ ...prev, open: false })) }}>
                        <ClearRoundedIcon />
                    </IconButton>
                </Box>
                <TabsCustom
                    disableDense
                    tabs={[
                        {
                            title: 'Detail',
                            content: () => <>
                                <Box display="flex" position="relative" style={{ overflow: 'hidden' }} justifyContent="center" alignItems="center" paddingTop={3} paddingBottom={5}>
                                    {
                                        fileDetail.file.is_dir ?
                                            <FolderIcon className={classes.avatar} style={{ color: fileDetail.file.data?.color ? fileDetail.file.data.color : '#69caf7' }} />
                                            : <Avatar
                                                className={classes.avatar}
                                                variant="square"
                                                src={fileDetail.file.thumbnail}
                                            />
                                    }
                                    {Boolean(fileDetail.file.data?.starred) && <div className={classes.starred}><GradeRoundedIcon /></div>}

                                    {Boolean(fileDetail.file.data?.is_remove) && <div className={classes.labelTrash}>Removed</div>}
                                </Box>
                                <Divider />
                                <Table size="small">
                                    <TableBody>
                                        <TableRow>
                                            <TableCell variant="head" style={{ maxWidth: 80 }}>Type</TableCell>
                                            <TableCell variant="body">{fileDetail.file.is_dir ? 'Folder' : fileDetail.file.extension}</TableCell>
                                        </TableRow>
                                        <TableRow>
                                            <TableCell variant="head" style={{ maxWidth: 80 }}>Size</TableCell>
                                            <TableCell variant="body">{fileDetail.file.is_dir ? '—' : fileDetail.file.filesize}</TableCell>
                                        </TableRow>
                                        {
                                            Boolean(fileDetail.parent) ?
                                                <TableRow>
                                                    <TableCell variant="head" style={{ maxWidth: 80 }}>Localtion</TableCell>
                                                    <TableCell variant="body">
                                                        <Box display="flex" alignItems="center" gridGap={8}>
                                                            <FolderIcon style={{ width: 24, height: 24, color: fileDetail.parent.color ? fileDetail.parent.color : '#69caf7' }} />
                                                            <Typography noWrap style={{ maxWidth: 120 }}>{fileDetail.parent.title}</Typography>
                                                        </Box>
                                                    </TableCell>
                                                </TableRow>
                                                :
                                                <TableRow>
                                                    <TableCell variant="head" style={{ maxWidth: 80 }}>Localtion</TableCell>
                                                    <TableCell variant="body">
                                                        <Box display="flex" alignItems="center" gridGap={8}>
                                                            <FolderIcon style={{ width: 24, height: 24, color: '#69caf7' }} />
                                                            <Typography noWrap style={{ maxWidth: 120 }}>My FIle</Typography>
                                                        </Box>
                                                    </TableCell>
                                                </TableRow>
                                        }
                                        <TableRow>
                                            <TableCell variant="head" style={{ maxWidth: 80 }}>Modified</TableCell>
                                            <TableCell variant="body">{fileDetail.file.filemtime}</TableCell>
                                        </TableRow>
                                        <TableRow>
                                            <TableCell variant="head" style={{ maxWidth: 80 }}>Created</TableCell>
                                            <TableCell variant="body">{fileDetail.file.filectime}</TableCell>
                                        </TableRow>
                                        <TableRow>
                                            <TableCell colSpan={2} >
                                                <FieldForm
                                                    compoment="textarea"
                                                    config={{
                                                        title: 'Description',
                                                    }}
                                                    post={fileDetail.file.data}
                                                    name="description"
                                                    onReview={(value) => fileDetail.file.data.description = value}
                                                />
                                            </TableCell>
                                        </TableRow>

                                        <TableRow >
                                            <TableCell colSpan={2} size="medium" align="right">
                                                <Button onClick={handleChangeDesription} variant="contained" color="primary">Save Changes</Button>
                                            </TableCell>
                                        </TableRow>

                                    </TableBody>
                                </Table>
                            </>
                        },
                        {
                            title: 'Activity',
                            content: () => <CardContent><Typography>Coming Soon</Typography></CardContent>
                        },
                    ]}
                />
            </div>
        )
    }

    return null;
}

export default FileDetail
