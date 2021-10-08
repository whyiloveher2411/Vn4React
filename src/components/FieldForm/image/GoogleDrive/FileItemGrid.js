import { Avatar, Box, makeStyles, Typography } from '@material-ui/core';
import FolderIcon from '@material-ui/icons/Folder';
import GradeRoundedIcon from '@material-ui/icons/GradeRounded';
import { FileDragDrop, MenuMouseRight } from 'components';
import React from 'react';
import FileManagerContext from './FileManagerContext';
import ListMenuMouseRightFile from './ListMenuMouseRightFile';


const useStyles = makeStyles((theme) => ({
    root: {
        position: 'relative',
        border: '1px solid',
        borderColor: theme.palette.dividerDark,
        width: 'calc( (100% - 75px) / 6 )',
        borderRadius: 3,
        '&.menuMouseRight-selected': {
            backgroundColor: theme.palette.dividerDark
        }
    },
    padding: {
        padding: '12px 16px',
        overflow: 'hidden',
        position: 'relative',
    },
    isImage: {
        backgroundImage: 'url(/admin/fileExtension/trans.jpg)',
    },
    avatar: {
        backgroundSize: '13px',
        maxWidth: '100%',
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'center',
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
            color: theme.palette.text.secondary,
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
        lineHeight: '350px',
        width: '350px',
        textAlign: 'center',
        fontSize: '20px',
        color: 'white',
        zIndex: 1,
        textTransform: 'uppercase',
        letterSpacing: '5px',
        textShadow: '1px 2px 5px #1f1f1f'
    }
}));

function FileItemGrid({ file, className, handleReloadDir, eventDragDropFile, ...rest }) {

    const classes = useStyles();

    const { openRenameDialog, fileSelected, configrmDialog, ajax, moveFileOrFolder } = React.useContext(FileManagerContext);

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
            component={'div'}
            className={className + ' ' + classes.root}
            {...FileDragDrop({ ...eventDragDropFile, path: file.dirpath + '/' + file.filename, fileOrigin: file })}
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

                        elem = e.currentTarget.querySelector('.avatar svg').cloneNode(true);

                        elem.style.width = '100px';
                        elem.style.height = '80px';
                        elem.style.left = '-100%';
                        elem.style.top = '0';
                        elem.style.position = 'fixed';
                        elem.style.pointerEvents = 'none';
                        elem.style.zIndex = '-1';

                        elem.setAttribute('viewBox', '1 4 22 16');
                        document.body.appendChild(elem);
                        let rect = elem.getBoundingClientRect();
                        e.dataTransfer.setDragImage(elem, rect.width / 2, rect.height / 2);

                    } else {

                        elem = e.currentTarget.querySelector('.avatar img').cloneNode(true);

                        elem.style.top = '0';
                        elem.style.position = 'fixed';
                        elem.style.left = '-100%';
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
                <div className={'avatar ' + classes.avatar}>
                    {
                        file.is_dir ?
                            <FolderIcon className={classes.avatar} style={{ width: 120, height: 120, color: file.data?.color ? file.data.color : '#69caf7' }} />
                            :
                            <Avatar
                                style={{ width: 200, height: 120 }}
                                className={classes.avatar + ' ' + (file.is_image ? classes.isImage : '')}
                                variant="square"
                                src={file.extension !== 'ico' ? file.thumbnail : file.public_path}
                            />
                    }
                </div>

                {Boolean(file.data?.starred) && <div className={classes.starred}><GradeRoundedIcon /></div>}

                {Boolean(file.data?.is_remove) && <div className={classes.labelTrash}>Removed</div>}

                <Box display="flex" alignItems="center" gridGap={8} className={classes.fileName}>

                    <Avatar
                        className={classes.extension}
                        variant="square"
                        src={'/admin/fileExtension/ico/' + (file.extension ? file.extension.replace(/[^a-zA-Z0-9]/g, "").toLowerCase() + '.jpg' : 'folder3.png')}

                    />
                    <Typography noWrap variant="body1">
                        {file.basename}
                    </Typography>
                </Box>
            </div>
        </MenuMouseRight >

    )
}

export default FileItemGrid
