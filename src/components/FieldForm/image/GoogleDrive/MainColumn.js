import { Box, makeStyles, Table, TableBody, TableCell, TableContainer, TableHead, TableRow } from '@material-ui/core';
import { FileDragDrop, MenuMouseRight } from 'components';
import React from 'react';
import FileItem from './FileItem';
import FileItemGrid from './FileItemGrid';
import FileManagerContext from './FileManagerContext';
import ListMenuMouseRightColumn from './ListMenuMouseRightColumn';
const useStyles = makeStyles((theme) => ({
    root: {
        border: '1px solid transparent',
        minHeight: '100%',
    },
    selected: {
        backgroundColor: theme.palette.divider
    },
    file: {
        // padding: '12px 16px',
        position: 'relative',
        cursor: 'pointer',
        '&:hover': {
            backgroundColor: 'rgba(0, 0, 0, 0.04)',
        },
        '&.__fileManager-selected': {
            backgroundColor: theme.palette.fileSelected,
            '& p': {
                color: theme.palette.text.primary,
            }
        },
        '&.actived:not(.noTick):before': {
            content: '""',
            position: 'absolute',
            top: 0,
            zIndex: 2,
            display: 'inline-block',
            width: 15,
            height: 15,
            backgroundImage: 'url(/admin/images/uploader-icons.png)',
            backgroundRepeat: 'no-repeat',
            backgroundPosition: '-17px 5px',
            backgroundColor: '#0073aa',
            width: 24,
            height: 24,
            right: -5,
            top: -5,
            boxShadow: '1px 1px 0px #0073aa, -1px -1px 0px #0073aa, 1px -1px 0px #0073aa, -1px 1px 0px #0073aa',
            border: '1px solid white',
            cursor: 'pointer',
        },
        '&.actived:hover:before': {
            backgroundPosition: '-56px 3px',
        },
        '&.actived:after': {
            content: '""',
            position: 'absolute',
            border: '3px solid #0073aa',
            top: 0,
            bottom: 0,
            left: 0,
            right: 0,
            zIndex: 1,
            pointerEvents: 'none',
        },

    },
    menuFile: {
        userSelect: 'none',
        maxHeight: 500,
        maxWidth: 448,
        minWidth: 320,
    },
    container: {
        maxHeight: 440,
    },
}));

export default React.memo(function MainColumn({ resource, eventDragDropFile, handleOnLoadDir, filesActive, ...rest }) {

    const { onDoubleClickDir, onDoubleClickImage, onDoubleClickFile, fileSelected, openNewDialog, ajax, extensions, search } = React.useContext(FileManagerContext);

    const classes = useStyles();

    const onDoubleClick = (item) => {

        if (item.is_dir) {
            onDoubleClickDir(item);
        } else if (item.is_image) {
            onDoubleClickImage(item);
        } else {
            onDoubleClickFile(item)
        }
    }

    const handleReloadDir = (path = resource.path) => {
        handleOnLoadDir(path, false, resource.version + 1);
    };

    const fileDragDropAttr = FileDragDrop(eventDragDropFile);

    if (resource) {

        if (resource.template === 'grid') {

            return (

                <MenuMouseRight
                    component={'div'}
                    listMenu={() => ListMenuMouseRightColumn({
                        file: resource.breadcrumbs[resource.breadcrumbs.length - 1].infoDetail,
                        handleReloadDir: handleReloadDir,
                        ajax: ajax,
                        setOpenNewDialog: openNewDialog[1],
                    })}
                    {...fileDragDropAttr}
                    {...rest}
                >
                    <Box
                        display="flex"
                        flexWrap="wrap"
                        gridGap={15}
                        padding={1.25}

                    >
                        {
                            resource.files.map((item, i) => {

                                if (!item.is_dir) {

                                    if (search.query && item.basename.search(search.query) === -1) {
                                        return <React.Fragment key={i}></React.Fragment>
                                    }

                                    if (!extensions[item.extension]) {
                                        return <React.Fragment key={i}></React.Fragment>
                                    }
                                }


                                return <FileItemGrid
                                    key={i}
                                    className={classes.file + ' '
                                        + ((item.data && item.data.is_remove) ? ' file-deleted ' : '')
                                        + ((fileSelected[0].file && fileSelected[0].file[item.dirpath + '/' + item.basename]) ? ' __fileManager-selected ' : '')
                                        + (filesActive[0]['/' + item.dirpath + '/' + item.basename] ? ' actived ' : '')
                                    }
                                    onClick={(e) => {

                                        e.stopPropagation();

                                        if (e.ctrlKey) {

                                            if (fileSelected[0].file && fileSelected[0].file[item.dirpath + '/' + item.basename]) {
                                                fileSelected[1](prev => {
                                                    delete prev.file[item.dirpath + '/' + item.basename];
                                                    return { ...prev };
                                                });
                                            } else {
                                                fileSelected[1](prev => ({ ...prev, file: { ...(prev.file ? prev.file : {}), [item.dirpath + '/' + item.basename]: item } }));
                                            }


                                        } else {
                                            fileSelected[1](prev => ({ ...prev, file: { [item.dirpath + '/' + item.basename]: item } }));
                                        }

                                    }}
                                    onDoubleClick={(e) => { onDoubleClick(item) }}
                                    file={item}
                                    handleReloadDir={handleReloadDir}
                                    eventDragDropFile={eventDragDropFile}
                                    datapath={item.dirpath + '/' + item.basename}
                                />
                            })
                        }
                    </Box>
                </MenuMouseRight>

            )

        }

        return (

            <MenuMouseRight
                component={TableContainer}
                listMenu={() => ListMenuMouseRightColumn({
                    file: resource.path,
                    handleReloadDir: handleReloadDir,
                    ajax: ajax,
                    setOpenNewDialog: openNewDialog[1],
                })}
                {...fileDragDropAttr}
                {...rest}
            >
                <Table stickyHeader size="small" aria-label="sticky dense table">
                    <TableHead>
                        <TableRow>
                            <TableCell>Name</TableCell>
                            <TableCell>Owner</TableCell>
                            <TableCell>Last modified</TableCell>
                            <TableCell>Fize size</TableCell>
                        </TableRow>
                    </TableHead>
                    <TableBody>
                        {
                            resource.files.map((item, i) => {

                                if (extensions && !item.is_dir && !extensions[item.extension]) {
                                    return <React.Fragment key={i}></React.Fragment>
                                }

                                return <FileItem
                                    key={i}
                                    className={classes.file + ' '
                                        + ((item.data && item.data.is_remove) ? ' file-deleted ' : '')
                                        + ((fileSelected[0].file && fileSelected[0].file[item.dirpath + '/' + item.basename]) ? ' __fileManager-selected ' : '')
                                        + (filesActive[0]['/' + item.dirpath + '/' + item.basename] ? ' actived noTick' : '')
                                    }
                                    onClick={(e) => {

                                        e.stopPropagation();

                                        if (e.ctrlKey) {

                                            if (fileSelected[0].file && fileSelected[0].file[item.dirpath + '/' + item.basename]) {
                                                fileSelected[1](prev => {
                                                    delete prev.file[item.dirpath + '/' + item.basename];
                                                    return { ...prev };
                                                });
                                            } else {
                                                fileSelected[1](prev => ({ ...prev, file: { ...(prev.file ? prev.file : {}), [item.dirpath + '/' + item.basename]: item } }));
                                            }

                                        } else {
                                            fileSelected[1](prev => ({ ...prev, file: { [item.dirpath + '/' + item.basename]: item } }));
                                        }
                                    }}
                                    onDoubleClick={(e) => { onDoubleClick(item) }}
                                    file={item}
                                    handleReloadDir={handleReloadDir}
                                    eventDragDropFile={eventDragDropFile}
                                    datapath={item.dirpath + '/' + item.basename}
                                />
                            })
                        }
                    </TableBody>
                </Table>
            </MenuMouseRight>
        )
    }
    return <></>;

}, (props1, props2) => {

    return !(
        props1.resource.path !== props2.resource.path ||
        props1.resource.version !== props2.resource.version ||
        props1.resource.template !== props2.resource.template ||
        JSON.stringify(props1.filesActive[0]) !== JSON.stringify(props2.filesActive[0])
    );

})
