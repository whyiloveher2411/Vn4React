import { SvgIcon } from '@material-ui/core';
import CloseRoundedIcon from '@material-ui/icons/CloseRounded';
import ControlCameraOutlinedIcon from '@material-ui/icons/ControlCameraOutlined';
import DeleteOutlineRoundedIcon from '@material-ui/icons/DeleteOutlineRounded';
import FileCopyOutlinedIcon from '@material-ui/icons/FileCopyOutlined';
import GradeRoundedIcon from '@material-ui/icons/GradeRounded';
import InfoOutlinedIcon from '@material-ui/icons/InfoOutlined';
import LinkOutlinedIcon from '@material-ui/icons/LinkOutlined';
import LoyaltyOutlinedIcon from '@material-ui/icons/LoyaltyOutlined';
import PaletteOutlinedIcon from '@material-ui/icons/PaletteOutlined';
import FileCopyRoundedIcon from '@material-ui/icons/FileCopyRounded';
import RestoreFromTrashOutlinedIcon from '@material-ui/icons/RestoreFromTrashOutlined';
import StarBorderRoundedIcon from '@material-ui/icons/StarBorderRounded';
import React from 'react';
import { copyArray } from 'utils/helper';
import { __ } from 'utils/i18n';
import SchemaColor from './SchemaColor';
import { MaterialIcon } from 'components';

export default function ListMenuMouseRightFile({ file, fileSelected, configrmDialog, handleReloadDir, ajax, setOpenRenameDialog, ...rest }) {

    return [
        {
            open: {
                title: __('Open'),
                hidden: file.is_dir ? false : true,
                icon: <ControlCameraOutlinedIcon />,
                action: {
                    onClick: (e, handleClose) => {
                        if (rest.onClick) {
                            handleReloadDir(file.dirpath + '/' + file.basename);
                            // rest.onClick(e);
                            handleClose();
                        }
                    }
                }
            },
            getLink: {
                title: __('Get link'),
                hidden: file.is_dir ? true : false,
                icon: <LinkOutlinedIcon />,
                action: {
                    onClick: (e, handleClose) => {
                        navigator.clipboard.writeText(file.public_path);
                        ajax.showNotification('Copied to clipboard.', 'info', { anchorOrigin: { vertical: 'top', horizontal: 'right' } });
                        handleClose();
                    }
                }
            },
            addToStarred: {
                title: file.data?.starred ? __('Remove From Starred') : __('Add to Starred'),
                icon: file.data?.starred ? <GradeRoundedIcon style={{ color: '#f4b400' }} /> : <StarBorderRoundedIcon />,
                action: {
                    onClick: (e, handleClose) => {
                        ajax.ajax({
                            url: 'file-manager/add-to-starred',
                            data: {
                                file: file,
                                value: !file.data?.starred
                            },
                            success: (result) => {
                                if (result.success) {
                                    handleReloadDir();
                                    handleClose();
                                }
                            }
                        });
                    }
                }
            },
            rename: {
                title: __('Rename'),
                icon: <SvgIcon height="24px" viewBox="0 0 24 24" width="24px">
                    <g><rect fill="none" height="24" width="24" /></g><g><g><polygon points="15,16 11,20 21,20 21,16" /><path d="M12.06,7.19L3,16.25V20h3.75l9.06-9.06L12.06,7.19z M5.92,18H5v-0.92l7.06-7.06l0.92,0.92L5.92,18z" /><path d="M18.71,8.04c0.39-0.39,0.39-1.02,0-1.41l-2.34-2.34C16.17,4.09,15.92,4,15.66,4c-0.25,0-0.51,0.1-0.7,0.29l-1.83,1.83 l3.75,3.75L18.71,8.04z" /></g></g>
                </SvgIcon>,
                action: {
                    onClick: (e, handleClose) => {
                        setOpenRenameDialog(prev => ({
                            ...prev,
                            open: true,
                            file: file,
                            origin: copyArray(file),
                            success: () => {
                                handleReloadDir();
                                setOpenRenameDialog(prev2 => ({ ...prev2, open: false }));
                            }
                        }));
                        handleClose();
                    }
                }
            },
            changeColor: {
                hidden: !file.is_dir,
                title: __('Change Color'),
                icon: <PaletteOutlinedIcon />,
                minWidth: '210px',
                children: [
                    {
                        colors: {
                            component: SchemaColor,
                            componentProps: {
                                file: file,
                                handleReloadDir: handleReloadDir
                            }
                        }
                    }
                ]
            },
            addTags: {
                title: __('Add Tags'),
                icon: <LoyaltyOutlinedIcon />,
                action: {
                    onClick: (e) => {
                        ajax.showNotification('Coming soon', 'info');
                    }
                }
            },
        },
        {
            cut: {
                title: __('Cut'),
                hidden: false,
                icon: <SvgIcon height="24px" viewBox="0 0 24 24" width="24px">
                    <path d="M0 0h24v24H0V0z" fill="none" /><path d="M9.64 7.64c.23-.5.36-1.05.36-1.64 0-2.21-1.79-4-4-4S2 3.79 2 6s1.79 4 4 4c.59 0 1.14-.13 1.64-.36L10 12l-2.36 2.36C7.14 14.13 6.59 14 6 14c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4c0-.59-.13-1.14-.36-1.64L12 14l7 7h3v-1L9.64 7.64zM6 8c-1.1 0-2-.89-2-2s.9-2 2-2 2 .89 2 2-.9 2-2 2zm0 12c-1.1 0-2-.89-2-2s.9-2 2-2 2 .89 2 2-.9 2-2 2zm6-7.5c-.28 0-.5-.22-.5-.5s.22-.5.5-.5.5.22.5.5-.22.5-.5.5zM19 3l-6 6 2 2 7-7V3h-3z" />
                </SvgIcon>,
                action: {
                    onClick: (e, handleClose) => {
                        window.__filemanageCopyOrCutFile = {
                            action: 'cut',
                            files: fileSelected[0].file
                                ? { ...fileSelected[0].file, [file.dirpath + '/' + file.basename]: file }
                                : { [file.dirpath + '/' + file.basename]: file }
                        };
                        handleClose();
                    }
                }

            },
            copy: {
                title: __('Copy'),
                icon: <MaterialIcon icon={{ custom: '<path d="M18 2H9c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h9c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H9V4h9v12zM3 15v-2h2v2H3zm0-5.5h2v2H3v-2zM10 20h2v2h-2v-2zm-7-1.5v-2h2v2H3zM5 22c-1.1 0-2-.9-2-2h2v2zm3.5 0h-2v-2h2v2zm5 0v-2h2c0 1.1-.9 2-2 2zM5 6v2H3c0-1.1.9-2 2-2z"></path>' }} />,
                action: {
                    onClick: (e, handleClose) => {
                        window.__filemanageCopyOrCutFile = {
                            action: 'copy',
                            files: fileSelected[0].file
                                ? { ...fileSelected[0].file, [file.dirpath + '/' + file.basename]: file }
                                : { [file.dirpath + '/' + file.basename]: file }
                        };
                        handleClose();
                    }
                }
            },
            paste: {
                title: __('Paste'),
                disabled: window.__filemanageCopyOrCutFile ? false : true,
                hidden: !file.is_dir,
                icon: <FileCopyOutlinedIcon />,
                action: {
                    onClick: (e, handleClose) => {
                        if (window.__filemanageCopyOrCutFile?.files) {

                            if (window.__filemanageCopyOrCutFile.files.dirpath !== (file.dirpath + '/' + file.basename)) {
                                ajax.ajax({
                                    url: 'file-manager/copy',
                                    data: {
                                        ...window.__filemanageCopyOrCutFile,
                                        folder: file,
                                    },
                                    success: (result) => {
                                        if (result.success) {
                                            delete window.__filemanageCopyOrCutFile;
                                            handleReloadDir();
                                            handleClose();
                                        }
                                    }
                                });
                            } else {
                                handleClose();
                            }
                        }
                    }
                }
            },
        },
        {
            viewDetail: {
                title: __('View Detail'),
                hidden: fileSelected[0].open ? true : false,
                icon: <InfoOutlinedIcon />,
                action: {
                    onClick: (e, handleClose) => {
                        e.stopPropagation();
                        fileSelected[1](prev => ({ ...prev, file: { ...(prev.file ? prev.file : {}), [file.dirpath + '/' + file.basename]: file }, open: true }));
                        handleClose();
                    }
                }
            },
            download: {
                title: __('Download'),
                icon: <SvgIcon enableBackground="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px">
                    <g><rect fill="none" height="24" width="24" /></g><g><path d="M18,15v3H6v-3H4v3c0,1.1,0.9,2,2,2h12c1.1,0,2-0.9,2-2v-3H18z M17,11l-1.41-1.41L13,12.17V4h-2v8.17L8.41,9.59L7,11l5,5 L17,11z" /></g>
                </SvgIcon>,
                action: {
                    onClick: (e, handleClose) => {
                        ajax.ajax({
                            url: 'file-manager/download',
                            data: {
                                file: file,
                            },
                            success: (result) => {
                                if (result.success) {

                                    let elem = document.createElement('iframe');
                                    elem.style.cssText = 'width:0;height:0,top:0;position:fixed;opacity:0;pointer-events:none;visibility:hidden;';
                                    elem.setAttribute('src', result.link);
                                    document.body.appendChild(elem);
                                    setTimeout(() => {
                                        elem.remove();
                                    }, 10000);

                                    //                                         <iframe id="my_iframe" style="display:none;"></iframe>
                                    // <script>
                                    // function Download(url) {
                                    //     document.getElementById('my_iframe').src = url;
                                    // };


                                }
                            }
                        });
                    }
                }
            },
        },
        {
            remove: {
                title: file.data.is_remove ? __('Restore') : __('Remove'),
                icon: file.data.is_remove ? <RestoreFromTrashOutlinedIcon /> : <DeleteOutlineRoundedIcon />,
                action: {
                    onClick: (e, handleClose) => {
                        ajax.ajax({
                            url: 'file-manager/remove',
                            data: {
                                file: file,
                                value: !file.data?.is_remove
                            },
                            success: (result) => {
                                if (result.success) {
                                    handleReloadDir();
                                    handleClose();
                                }
                            }
                        });
                    }
                }
            },
            permanentlyDeleted: {
                title: __('Permanently Deleted'),
                hidden: file.data?.is_remove ? false : true,
                icon: <CloseRoundedIcon />,
                action: {
                    onClick: (e, handleClose) => {
                        handleClose();
                        configrmDialog[1](() => ({
                            file: file,
                            open: true,
                            success: (result) => {
                                if (result.success) {
                                    handleReloadDir();
                                    handleClose();
                                    configrmDialog[1]((prev) => ({
                                        ...prev,
                                        open: false
                                    }));
                                }
                            }
                        }));
                    }
                }
            },
        },
    ];
}