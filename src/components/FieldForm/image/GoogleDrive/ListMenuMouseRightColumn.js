import { SvgIcon } from '@material-ui/core';
import FileCopyOutlinedIcon from '@material-ui/icons/FileCopyOutlined';
import React from 'react';

export default function ListMenuMouseRightColumn({ file, ajax, handleReloadDir, setOpenNewDialog, ...rest }) {

    return [
        {
            new: {
                title: 'New',
                icon: <SvgIcon enableBackground="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px">
                    <path d="M0 0h24v24H0V0z" fill="none" /><path d="M20 6h-8l-2-2H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm0 12H4V6h5.17l2 2H20v10zm-8-4h2v2h2v-2h2v-2h-2v-2h-2v2h-2z" />
                </SvgIcon>,
                action: {
                    onClick: (e, handleClose) => {
                        setOpenNewDialog(prev => ({
                            ...prev,
                            open: true,
                            folder: file,
                            success: () => {
                                handleReloadDir();
                                setOpenNewDialog(prev2 => ({ ...prev2, open: false }));
                            }
                        }));
                        handleClose();
                    }
                }
            },
            paste: {
                title: 'Paste',
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
                            }else{
                                handleClose();
                            }
                        }
                    }
                }
            },
        },
        {
            uploadFile: {
                title: 'Upload File',
                icon: <SvgIcon enableBackground="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px">
                    <g><rect fill="none" height="24" width="24" /></g><g><g><path d="M14,2H6C4.9,2,4.01,2.9,4.01,4L4,20c0,1.1,0.89,2,1.99,2H18c1.1,0,2-0.9,2-2V8L14,2z M18,20H6V4h7v5h5V20z M8,15.01 l1.41,1.41L11,14.84V19h2v-4.16l1.59,1.59L16,15.01L12.01,11L8,15.01z" /></g></g>
                </SvgIcon>,
                action: {
                    onClick: (e) => {

                    }
                }
            },
            uploadFolder: {
                title: 'Upload Folder',
                icon: <SvgIcon enableBackground="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px">
                    <g><rect fill="none" height="24" width="24" /></g><g><path d="M20,6h-8l-2-2H4C2.9,4,2.01,4.9,2.01,6L2,18c0,1.1,0.9,2,2,2h16c1.1,0,2-0.9,2-2V8C22,6.9,21.1,6,20,6z M20,18L4,18V6h5.17 l2,2H20V18z M9.41,14.42L11,12.84V17h2v-4.16l1.59,1.59L16,13.01L12.01,9L8,13.01L9.41,14.42z" /></g>
                </SvgIcon>,
                action: {
                    onClick: (e) => {

                    }
                }
            },
        },
    ]
}