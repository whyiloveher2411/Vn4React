import { SvgIcon } from '@material-ui/core';
import ControlCameraOutlinedIcon from '@material-ui/icons/ControlCameraOutlined';
import DeleteOutlineRoundedIcon from '@material-ui/icons/DeleteOutlineRounded';
import InfoOutlinedIcon from '@material-ui/icons/InfoOutlined';
import LinkOutlinedIcon from '@material-ui/icons/LinkOutlined';
import LoyaltyOutlinedIcon from '@material-ui/icons/LoyaltyOutlined';
import PaletteOutlinedIcon from '@material-ui/icons/PaletteOutlined';
import StarBorderRoundedIcon from '@material-ui/icons/StarBorderRounded';
import React from 'react';
import { useAjax } from 'utils/useAjax';
import SchemaColor from './SchemaColor';

export default function MenuMouseRightFileOrFolder(file, rest) {

    const ajax = useAjax();

    return [
        {
            open: {
                title: 'Open',
                icon: <ControlCameraOutlinedIcon />,
                action: {
                    onClick: (e, handleClose) => {
                        if (rest.onClick) {
                            rest.onClick(e);
                            handleClose();
                        }
                    }
                }
            },
            getLink: {
                title: 'Get link',
                icon: <LinkOutlinedIcon />,
                action: {
                    onClick: (e) => {

                    }
                }
            },
            moveTo: {
                title: 'Move to',
                icon: <SvgIcon height="24px" viewBox="0 0 24 24" width="24px">
                    <g><rect fill="none" height="24" width="24" /></g><g><path d="M20,6h-8l-2-2H4C2.9,4,2,4.9,2,6v12c0,1.1,0.9,2,2,2h16c1.1,0,2-0.9,2-2V8C22,6.9,21.1,6,20,6z M20,18H4V6h5.17l1.41,1.41 L11.17,8H20V18z M12.16,12H8v2h4.16l-1.59,1.59L11.99,17L16,13.01L11.99,9l-1.41,1.41L12.16,12z" /></g>
                </SvgIcon>,
                action: {
                    onClick: (e) => {

                    }
                }
            },
            addToStarred: {
                title: 'Add to Starred',
                icon: <StarBorderRoundedIcon />,
                action: {
                    onClick: (e) => {

                    }
                }
            },
            rename: {
                title: 'Rename',
                icon: <SvgIcon height="24px" viewBox="0 0 24 24" width="24px">
                    <g><rect fill="none" height="24" width="24" /></g><g><g><polygon points="15,16 11,20 21,20 21,16" /><path d="M12.06,7.19L3,16.25V20h3.75l9.06-9.06L12.06,7.19z M5.92,18H5v-0.92l7.06-7.06l0.92,0.92L5.92,18z" /><path d="M18.71,8.04c0.39-0.39,0.39-1.02,0-1.41l-2.34-2.34C16.17,4.09,15.92,4,15.66,4c-0.25,0-0.51,0.1-0.7,0.29l-1.83,1.83 l3.75,3.75L18.71,8.04z" /></g></g>
                </SvgIcon>,
                action: {
                    onClick: (e) => {

                    }
                }
            },
            changeColor: {
                hidden: !file.is_dir,
                title: 'Change Color',
                icon: <PaletteOutlinedIcon />,
                minWidth: '210px',
                children: [
                    {
                        colors: {
                            component: SchemaColor,
                            componentProps: {
                                file: file
                            }
                        }
                    }
                ]
            },
            addTags: {
                title: 'Add Tags',
                icon: <LoyaltyOutlinedIcon />,
                action: {
                    onClick: (e) => {

                    }
                }
            },
        },
        {
            viewDetail: {
                title: 'View Detail',
                icon: <InfoOutlinedIcon />,
                action: {
                    onClick: (e) => {

                    }
                }
            },
            download: {
                title: 'Download',
                icon: <SvgIcon enableBackground="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px">
                    <g><rect fill="none" height="24" width="24" /></g><g><path d="M18,15v3H6v-3H4v3c0,1.1,0.9,2,2,2h12c1.1,0,2-0.9,2-2v-3H18z M17,11l-1.41-1.41L13,12.17V4h-2v8.17L8.41,9.59L7,11l5,5 L17,11z" /></g>
                </SvgIcon>,
                action: {
                    onClick: (e) => {

                    }
                }
            },
        },
        {
            remove: {
                title: 'Remove',
                icon: <DeleteOutlineRoundedIcon />,
                action: {
                    onClick: (e) => {

                    }
                }
            },
        }
    ];

};