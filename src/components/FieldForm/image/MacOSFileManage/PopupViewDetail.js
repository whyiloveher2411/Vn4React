import { Avatar, Box, Card, CardContent, CardHeader, CircularProgress, Collapse, IconButton, makeStyles, Slide, Typography } from '@material-ui/core';
import CheckCircleRoundedIcon from '@material-ui/icons/CheckCircleRounded';
import ClearRoundedIcon from '@material-ui/icons/ClearRounded';
import ExpandMoreIcon from '@material-ui/icons/ExpandMore';
import FolderOpenIcon from '@material-ui/icons/FolderOpen';
import HighlightOffRoundedIcon from '@material-ui/icons/HighlightOffRounded';
import { Skeleton } from '@material-ui/lab';
import React from 'react';
import { humanFileSize } from 'utils/helper';


const useStyles = makeStyles((theme) => ({
    upload: {
        position: 'absolute', right: 10, bottom: 10, maxWidth: 360, minWidth: 360,
        boxShadow: '0 2px 8px 0 rgb(0 0 0 / 20%)',
        '& .MuiCardContent-root': {
            padding: 16
        }
    },
    uploadHeader: {
        backgroundColor: '#323232',
        height: 54,
        '& .MuiCardHeader-title': {
            color: theme.palette.primary.contrastText,
        },
        '& .MuiCardHeader-action': {
            marginTop: -14,
            marginRight: -16,
        }
    },
    circularBottom: {
        color: theme.palette.grey[theme.palette.type === 'light' ? 200 : 700],
    },
    fileUpload: {
        marginBottom: theme.spacing(1)
    },
    uploadComplete: {
        color: theme.palette.buttonSave.main,
        marginTop: -theme.spacing(1),
        marginBottom: -theme.spacing(1),
        '&:hover': {
            color: 'unset',
        },
        '&:hover $uploadCompleteIcon': {
            display: 'none'
        },
        '&:hover $uploadCompleteIconHover': {
            display: 'block'
        },
    },
    uploadCompleteIcon: {
        display: 'block',
    },
    uploadCompleteIconHover: {
        display: 'none',
    }
}));

function PopupViewDetail({ filesUpload = {}, setFilesUpload }) {

    const classes = useStyles();

    return (
        <Slide direction="up" in={true} mountOnEnter unmountOnExit className={classes.upload}>
            <Card  >
                <CardHeader
                    action={
                        <IconButton style={{ color: 'white' }} aria-label="settings">
                            <ClearRoundedIcon />
                        </IconButton>
                    }
                    title={'Uploading ' + Object.keys(filesUpload).length + ' item'}
                    className={classes.uploadHeader}
                />
                <Collapse in={true}>
                    <CardContent>
                        {
                            Object.keys(filesUpload).map(key => (
                                <Box key={key} className={classes.fileUpload} display="flex" gridGap={16} alignItems="center">
                                    {
                                        filesUpload[key].thumbnail ?
                                            <Avatar
                                                src={filesUpload[key].thumbnail}
                                                style={{ flexShrink: 0 }}
                                                variant="square"
                                            />
                                            :
                                            <Skeleton style={{ flexShrink: 0 }} variant="rect" width={40} height={40} />
                                    }

                                    <Typography noWrap style={{ lineHeight: '40px', width: '100%' }}>
                                        {filesUpload[key].fileNmae}
                                        <Typography component="span" variant="body2" > ({humanFileSize(filesUpload[key].sizeUpload)})</Typography>
                                    </Typography>

                                    {
                                        filesUpload[key].uploadComplete !== undefined ?
                                            (
                                                filesUpload[key].uploadComplete === true ?
                                                    <IconButton className={classes.uploadComplete}>
                                                        <CheckCircleRoundedIcon className={classes.uploadCompleteIcon} />
                                                        <FolderOpenIcon className={classes.uploadCompleteIconHover} />
                                                    </IconButton>
                                                    :
                                                    <IconButton
                                                        onClick={() => {
                                                            setFilesUpload(prev => {
                                                                delete prev[key];
                                                                return { ...prev };
                                                            })
                                                        }}
                                                        color="secondary"
                                                        style={{ margin: '-8px 0' }}
                                                    >
                                                        <HighlightOffRoundedIcon />
                                                    </IconButton>
                                            )
                                            :
                                            <Box position="relative" style={{ flexShrink: 0, width: 40, height: 40 }} display="inline-flex">
                                                <CircularProgress
                                                    variant="determinate"
                                                    size={40}
                                                    thickness={4}
                                                    className={classes.circularBottom}
                                                    value={100}
                                                    style={{ position: 'absolute', left: 0 }}
                                                />
                                                <CircularProgress
                                                    size="small"
                                                    size={40}
                                                    variant="determinate"
                                                    style={{ position: 'absolute', left: 0 }}
                                                    value={filesUpload[key].percentLoaded}
                                                />
                                                <Box
                                                    top={0}
                                                    left={0}
                                                    bottom={0}
                                                    right={0}
                                                    position="absolute"
                                                    display="flex"
                                                    alignItems="center"
                                                    justifyContent="center"
                                                >
                                                    <Typography variant="caption" component="div" color="textSecondary">
                                                        {`${filesUpload[key].percentLoaded}%`}
                                                    </Typography>
                                                </Box>
                                            </Box>
                                    }
                                </Box>
                            ))
                        }
                    </CardContent>
                </Collapse>
            </Card>
        </Slide>
    )
}

export default PopupViewDetail
