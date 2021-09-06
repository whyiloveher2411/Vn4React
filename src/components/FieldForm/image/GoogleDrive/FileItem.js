import { Avatar, Box, Chip, makeStyles, TableCell, TableRow, Typography } from '@material-ui/core';
import FolderIcon from '@material-ui/icons/Folder';
import GradeRoundedIcon from '@material-ui/icons/GradeRounded';
import { FileDragDrop, MenuMouseRight } from 'components';
import React from 'react';
import FileManagerContext from './FileManagerContext';
import ListMenuMouseRightFile from './ListMenuMouseRightFile';

const useStyles = makeStyles(() => ({
    root: {
        '&.menuMouseRight-selected': {
            backgroundColor: '#e8f0fe'
        }
    },
    avatar: {
        backgroundImage: 'url(/admin/fileExtension/trans.jpg)',
        backgroundSize: '13px'
    },
    starred: {
        color: '#f4b400'
    },
    fileName: {
        borderRight: '1px solid transparent',
        borderLeft: '1px solid transparent',
        borderTop: '1px solid transparent',
    }
}));

function FileItem({ file, className, handleReloadDir, eventDragDropFile, ...rest }) {

    const classes = useStyles();

    const { openRenameDialog, fileSelected, ajax, configrmDialog, moveFileOrFolder } = React.useContext(FileManagerContext);

    const handleMovieFile = () => {

        if (window.__fileMangerMoveFile && window.__fileMangerMoveFile['file_element']) {
            window.__fileMangerMoveFile['file_element'].remove();
            delete window.__fileMangerMoveFile['file_element'];
        }

        if (window.__fileMangerMoveFile && window.__fileMangerMoveFile['file']) {

            let fileNeedMove = window.__fileMangerMoveFile['file'];

            delete window.__fileMangerMoveFile['file'];
            console.log(fileNeedMove);

            if (file.is_dir) {
                moveFileOrFolder(fileNeedMove, file, () => {
                    handleReloadDir();
                });
            }
        }
    }

    return (
        <MenuMouseRight
            component={TableRow}
            className={className + ' ' + classes.root}
            listMenu={() => ListMenuMouseRightFile({
                file: file,
                onClick: rest.onClick,
                handleReloadDir: handleReloadDir,
                setOpenRenameDialog: openRenameDialog[1],
                fileSelected: fileSelected,
                ajax: ajax,
                configrmDialog: configrmDialog,
            })}
            {...rest}
        >

            <TableCell
                className={classes.fileName}
                {...FileDragDrop({ ...eventDragDropFile, path: file.dirpath + '/' + file.filename, fileOrigin: file })}
            >
                <Box display="flex" alignItems="center" gridGap={8}>

                    <div
                        className={classes.padding}
                        draggable
                        onDragStart={(e) => {

                            if (!window.__fileMangerMoveFile) {
                                window.__fileMangerMoveFile = [];
                            }

                            window.__fileMangerMoveFile['file'] = file;

                            let elem;

                            if (file.is_dir) {

                                elem = e.currentTarget.cloneNode(true);

                                elem.style.width = '40px';
                                elem.style.height = '40px';
                                elem.style.top = '0';
                                elem.style.position = 'fixed';
                                elem.style.pointerEvents = 'none';
                                elem.style.zIndex = '-1';

                                elem.setAttribute('viewBox', '1 4 22 16');
                                document.body.appendChild(elem);
                                let rect = elem.getBoundingClientRect();
                                e.dataTransfer.setDragImage(elem, 20, 20);

                            } else {

                                elem = e.currentTarget.querySelector('.avatar img').cloneNode(true);

                                elem.style.top = '0';
                                elem.style.position = 'fixed';
                                elem.style.pointerEvents = 'none';
                                elem.style.zIndex = '-1';
                                elem.style.width = '122px';
                                elem.style.height = 'auto';

                                document.body.appendChild(elem);
                                let rect = elem.getBoundingClientRect();
                                e.dataTransfer.setDragImage(elem, rect.width / 2, rect.height / 2);
                            }

                            window.__fileMangerMoveFile['file_element'] = elem;

                        }}
                        onDragEnter={(e) => {
                            e.currentTarget.style.bordeSize = '1px';
                            e.currentTarget.style.borderColor = '#2196f3';
                            e.currentTarget.style.backgroundColor = '#e3f2fd';
                        }}
                        onDragLeave={(e) => {
                            e.currentTarget.style.borderColor = null;
                            e.currentTarget.style.backgroundColor = null;
                            e.currentTarget.style.transition = 'background 0.08s';
                        }}
                        onDrop={(e) => {
                            handleMovieFile();
                        }}
                    >
                        {
                            file.is_dir ?
                                <FolderIcon className={'avatar'} style={{ width: 40, height: 40, color: file.data?.color ? file.data.color : '#69caf7' }} />
                                :
                                <Avatar
                                    className={classes.avatar + ' avatar'}
                                    variant="square"
                                    src={file.thumbnail}
                                />
                        }
                    </div>
                    <Typography noWrap variant="body1">
                        {file.basename}
                    </Typography>
                    {Boolean(file.data?.starred) && <GradeRoundedIcon className={classes.starred} />}
                    {Boolean(file.data?.is_remove) && <Chip size="small" label="Removed" color="secondary" />}
                </Box>
            </TableCell>

            <TableCell>
            </TableCell>

            <TableCell>
                {file.filemtime}
            </TableCell>
            <TableCell>
                {
                    !file.is_dir ?
                        file.filesize
                        : '—'
                }
            </TableCell>
        </MenuMouseRight >

    )
}

export default FileItem
