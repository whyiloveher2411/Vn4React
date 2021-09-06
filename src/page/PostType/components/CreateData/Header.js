// import DateFnsUtils from '@date-io/date-fns';
import { Button, colors, Dialog, DialogActions, DialogContent, CircularProgress, DialogContentText, DialogTitle, Divider, Fab, Grid, Chip, IconButton, List, ListItemIcon, ListItem, ListItemText, Menu, MenuItem, Tooltip, Typography } from '@material-ui/core';
import AddRoundedIcon from '@material-ui/icons/AddRounded';
import ArrowBackOutlined from '@material-ui/icons/ArrowBackOutlined';
import DeleteIcon from '@material-ui/icons/Delete';
import EventIcon from '@material-ui/icons/Event';
import FormatListBulletedRoundedIcon from '@material-ui/icons/FormatListBulletedRounded';
import LinkRoundedIcon from '@material-ui/icons/LinkRounded';
import LockIcon from '@material-ui/icons/Lock';
import NoteIcon from '@material-ui/icons/Note';
import PublicRoundedIcon from '@material-ui/icons/PublicRounded';
import StarBorderOutlinedIcon from '@material-ui/icons/StarBorderOutlined';
import StarOutlinedIcon from '@material-ui/icons/StarOutlined';
import UpdateIcon from '@material-ui/icons/Update';
import VisibilityIcon from '@material-ui/icons/Visibility';
import VpnKeyRoundedIcon from '@material-ui/icons/VpnKeyRounded';
import { makeStyles } from '@material-ui/styles';
import clsx from 'clsx';
import { FieldForm, Hook, CustomTooltip } from 'components';
import React from 'react';
import { Link, useHistory } from 'react-router-dom';
import { useAjax } from 'utils/useAjax';
import { checkPermission } from 'utils/user';
import LabelPost from '../LabelPost';
import InfoOutlinedIcon from '@material-ui/icons/InfoOutlined';
import PostTypeInfo from './PostTypeInfo';

const useStyles = makeStyles((theme) => ({
    root: {
        top: 0,
        position: 'sticky',
        backgroundColor: '#f4f6f8',
        zIndex: 9,
        margin: '0 -2px',
        '& $dateRelease': {
            display: 'none'
        },
    },
    dateRelease: {

    },
    infopage: {
        lineHeight: '20px'
    },
    backToList: {
        cursor: 'pointer',
    },
    grid: {
        marginBottom: 0
    },
    rowAction: {
        '& .MuiIconButton-root': {
            width: 40,
            height: 40,
            margin: '0 1px',
            opacity: 0.5,
            color: '#202124',
            '&:hover': {
                opacity: 1
            }
        }
    },

    divider: {
        backgroundColor: colors.grey[300],
    },
    saveButton: {
        color: theme.palette.white,
        backgroundColor: colors.green[600],
        '&:hover': {
            backgroundColor: colors.green[900],
        },
    },

    deleteButton: {
        color: theme.palette.white,
        backgroundColor: colors.red[600],
        '&:hover': {
            backgroundColor: colors.red[900],
        },
    },
    seperateAction: {
        display: 'inline-block',
        padding: '0 10px',
        position: 'relative',
        '&:first-child': {
            paddingLeft: 0
        },
        '&:last-child': {
            paddingRight: 0,
            '&::after': {
                display: 'none'
            }
        },
        '&::after': {
            content: '""',
            display: 'inline-block',
            position: 'absolute',
            width: 1,
            height: 20,
            background: '#dedede',
            top: '50%',
            right: 0,
            transform: 'translateY(-50%)'
        }
    }
}))

const Header = (props) => {
    const { className, title, label, showLoadingButton, handleSubmit, singularName, data, postType, goBack, backToList, hiddenAddButton, onReview, ...rest } = props;

    const classes = useStyles()
    const history = useHistory();

    const handleBackToList = () => {
        history.push('/post-type/' + postType + '/list');
    };

    const statusRef = React.useRef(null);
    const viewRef = React.useRef(null);

    const [openMenuStatus, setOpenMenuStatus] = React.useState(false)
    const [openMenuView, setOpenMenuView] = React.useState(false)
    const [openDataPicker, setOpenDataPicker] = React.useState(false);

    const [dateForm, setDateForm] = React.useState({ post_date_gmt: data.post?.post_date_gmt ? (data.post.post_date_gmt + '000') * 1 : '' });

    const [passwordProtected, setPasswordProtected] = React.useState({
        open: false,
        value: data.post?.password
    });

    const handleDateChange = (d) => {
        if (d) {

            let d2 = new Date(d);

            if (data && data.post) {
                data.post.post_date_gmt = (d2.getTime() + '').slice(0, -3);
                setDateForm({ post_date_gmt: d2.getTime() });
            }

        } else {
            data.post.post_date_gmt = null;
            setDateForm({ post_date_gmt: '' });
        }

    };

    const [updateView, setUpdateview] = React.useState(0);
    const [confirmDelete, setConfirmDelete] = React.useState(false);

    const handelOnClickDelete = () => {
        setConfirmDelete(true);
    };

    const closeDialogConfirmDelete = () => {
        setConfirmDelete(false);
    };

    const { ajax, Loading } = useAjax();

    const deletePost = () => {
        setConfirmDelete(false);
        ajax({
            url: 'post-type/delete/' + data.type,
            method: 'POST',
            data: data.post,
            success: () => {
                history.push('/post-type/' + postType + '/list');
            }
        });
    };



    const handleOnClickStar = () => {
        data.post.starred = data.post.starred * 1 === 1 ? 0 : 1;
        setUpdateview(updateView + 1);
    };

    const updateStatus = (status) => {

        if (data.post.status !== status) {
            data.post.status_old = data.post.status;
            data.post.status = status;
            setUpdateview(updateView + 1);
            setOpenMenuStatus(false);
        }
    }

    const restorePost = () => {

        if (data.post.status === 'trash') {

            if (data.post.status_old === 'trash') {
                data.post.status = 'publish';
            } else {
                data.post.status = data.post.status_old;
            }

            data.post.status_old = 'trash';
            setUpdateview(updateView + 1);
            setOpenMenuStatus(false);
        }

    };

    const updateViewStatus = (status, value = false) => {
        if (status === 'password') {
            if (value) {
                data.post.visibility = status;
                data.post.password = value;
                setUpdateview(updateView + 1);
                setOpenMenuView(false);
                setPasswordProtected({ ...setPasswordProtected, open: false });
            } else {
                setPasswordProtected({ ...setPasswordProtected, open: true });
            }
        } else {
            data.post.visibility = status;
            setUpdateview(updateView + 1);
            setOpenMenuView(false);
        }
    }

    return (
        <div {...rest} className={clsx(classes.root, className)}>
            <Grid
                alignItems="flex-end"
                container
                className={classes.grid}
                justify="space-between"
                alignItems="center"
                spacing={3}>
                <Grid item>
                    <Typography className={classes.infopage} component="h2" gutterBottom variant="overline">
                        Content / <span className={classes.backToList} onClick={handleBackToList}>{data.config?.title}</span> / {title} <LabelPost post={data.post} />
                    </Typography>
                    <Typography component="h1" variant="h3" className={classes.rowAction}>
                        <div className={classes.seperateAction}>
                            {
                                Boolean(goBack) &&
                                <Tooltip className={classes.backToList} onClick={() => history.goBack()} title="Go Back" aria-label="go-back">
                                    <IconButton color="default" aria-label="Go Back" component="span">
                                        <ArrowBackOutlined />
                                    </IconButton>
                                </Tooltip>
                            }

                            {
                                Boolean(backToList) &&
                                <Tooltip className={classes.backToList} onClick={handleBackToList} title="Back to list" aria-label="back-to-list">
                                    <IconButton color="default" aria-label="Back to list" component="span">
                                        <FormatListBulletedRoundedIcon />
                                    </IconButton>
                                </Tooltip>
                            }
                        </div>
                        <div className={classes.seperateAction}>
                            <Tooltip title="Starred" aria-label="Starred">
                                <IconButton onClick={handleOnClickStar} aria-label="Starred" component="span">
                                    {
                                        data.post?.starred
                                            ?
                                            <StarOutlinedIcon style={{ color: '#f4b400' }} />
                                            :
                                            <StarBorderOutlinedIcon />
                                    }
                                </IconButton>
                            </Tooltip>

                            <Tooltip title="Status" aria-label="Status">
                                <IconButton ref={statusRef} onClick={() => setOpenMenuStatus(true)} color="default" aria-label="Status" component="span">
                                    {
                                        data.post?.status === 'draft' ?
                                            <NoteIcon />
                                            :
                                            data.post?.status === 'pending' ?
                                                <UpdateIcon />
                                                :
                                                data.post?.status === 'trash' ?
                                                    <DeleteIcon />
                                                    :
                                                    <PublicRoundedIcon />
                                    }
                                </IconButton>
                            </Tooltip>

                            <Menu
                                anchorEl={statusRef.current}
                                anchorOrigin={{
                                    vertical: 'top',
                                    horizontal: 'left',
                                }}
                                classes={{ paper: classes.menu }}
                                onClose={() => setOpenMenuStatus(false)}
                                open={openMenuStatus}
                                transformOrigin={{
                                    vertical: 'top',
                                    horizontal: 'left',
                                }}>
                                {
                                    checkPermission(postType + '_publish') &&
                                    <MenuItem onClick={e => updateStatus('publish')}>
                                        <ListItemIcon>
                                            <PublicRoundedIcon />
                                        </ListItemIcon>
                                        <ListItemText primary="Publish" />
                                    </MenuItem>
                                }
                                <MenuItem onClick={e => updateStatus('draft')}>
                                    <ListItemIcon>
                                        <NoteIcon />
                                    </ListItemIcon>
                                    <ListItemText primary="Draft" />
                                </MenuItem>
                                <MenuItem onClick={e => updateStatus('pending')}>
                                    <ListItemIcon>
                                        <UpdateIcon />
                                    </ListItemIcon>
                                    <ListItemText primary="Pending" />
                                </MenuItem>
                                {
                                    checkPermission(postType + '_trash') &&
                                    <MenuItem onClick={e => updateStatus('trash')}>
                                        <ListItemIcon>
                                            <DeleteIcon />
                                        </ListItemIcon>
                                        <ListItemText primary="Trash" />
                                    </MenuItem>
                                }
                            </Menu>

                            <Tooltip title="Release date" aria-label="release-date">
                                <IconButton onClick={() => { setOpenDataPicker(true); }} color="default" aria-label="Release date" component="span">
                                    <EventIcon />
                                </IconButton>
                            </Tooltip>
                            <div style={{ display: 'none' }}>
                                <FieldForm
                                    compoment="dateTime"
                                    config={{
                                        title: "Release date"
                                    }}
                                    name='post_date_gmt'
                                    post={dateForm}
                                    onReview={(value) => handleDateChange(value)}
                                    open={openDataPicker}
                                    onClose={() => setOpenDataPicker(false)}
                                />
                            </div>

                            <Tooltip title="Visibility" aria-label="visibility">
                                <IconButton ref={viewRef} onClick={() => setOpenMenuView(true)} color="default" aria-label="Visibility" component="span">
                                    {
                                        data.post?.visibility === 'password' ?
                                            <VpnKeyRoundedIcon />
                                            :
                                            data.post?.visibility === 'private' ?
                                                <LockIcon />
                                                :
                                                <VisibilityIcon />
                                    }
                                </IconButton>
                            </Tooltip>
                            <Menu
                                anchorEl={viewRef.current}
                                anchorOrigin={{
                                    vertical: 'top',
                                    horizontal: 'left',
                                }}
                                classes={{ paper: classes.menu }}
                                onClose={() => setOpenMenuView(false)}
                                open={openMenuView}
                                transformOrigin={{
                                    vertical: 'top',
                                    horizontal: 'left',
                                }}>
                                <MenuItem onClick={e => updateViewStatus('publish')}>
                                    <ListItemIcon>
                                        <VisibilityIcon />
                                    </ListItemIcon>
                                    <ListItemText primary="Public" />
                                </MenuItem>
                                <MenuItem onClick={e => updateViewStatus('password')}>
                                    <ListItemIcon>
                                        <VpnKeyRoundedIcon />
                                    </ListItemIcon>
                                    <ListItemText primary="Password protected" />
                                </MenuItem>
                                <MenuItem onClick={e => updateViewStatus('private')}>
                                    <ListItemIcon>
                                        <LockIcon />
                                    </ListItemIcon>
                                    <ListItemText primary="Private" />
                                </MenuItem>
                            </Menu>
                            <Dialog
                                onClose={() => setPasswordProtected({ ...passwordProtected, open: false })}
                                open={passwordProtected.open}>
                                <DialogTitle>Password confirm</DialogTitle>
                                <DialogContent>
                                    <DialogContentText>
                                        Protected with a password you choose. Only those with the password can view this post
                                    </DialogContentText>
                                    <FieldForm
                                        compoment='password'
                                        config={{ title: 'Password' }}
                                        post={{ _password: data.post?.password }}
                                        name='password'
                                        onReview={(value) => setPasswordProtected({ ...passwordProtected, value: value })}
                                    />
                                </DialogContent>
                                <DialogActions>
                                    <Button onClick={() => setPasswordProtected({ ...passwordProtected, open: false })} color="default">
                                        Cancel
                                    </Button>
                                    <Button onClick={() => updateViewStatus('password', passwordProtected.value ?? data.post?.password)} color="primary">
                                        Ok
                                    </Button>
                                </DialogActions>
                            </Dialog>
                        </div>
                        <div className={classes.seperateAction}>
                            {
                                Boolean(data.post?.id) &&
                                <>
                                    <CustomTooltip interactive={true} title={<PostTypeInfo data={data} />}   >
                                        <IconButton>
                                            <InfoOutlinedIcon />
                                        </IconButton>
                                    </CustomTooltip>
                                </>
                            }

                            {
                                Boolean(data.post && data.post._permalink) &&
                                <Tooltip title="View post" aria-label="view-post">
                                    <IconButton href={data.post._permalink} style={{ color: '#337ab7', opacity: 1 }} target="_blank" >
                                        <LinkRoundedIcon />
                                    </IconButton>
                                </Tooltip>
                            }
                        </div>
                        <div className={classes.seperateAction}>
                            <Hook hook="ActionWithPostTypeDetail" screen="detail" post={data.post ?? null} />
                        </div>
                    </Typography>
                </Grid>
                <Grid item style={{ paddingTop: 0 }}>
                    {
                        data.post?.status === 'trash' &&
                        <>
                            {
                                checkPermission(postType + '_delete') && data.post?.id &&
                                <Button style={{ marginRight: 8 }} className={classes.deleteButton} onClick={handelOnClickDelete} color="default" variant="contained">
                                    Delete
                                </Button>
                            }

                            {
                                checkPermission(postType + '_restore') &&
                                <Tooltip title="Restore" aria-label="Restore">
                                    <Button style={{ marginRight: 8 }} className={classes.saveButton} onClick={restorePost} color="default" variant="contained">
                                        Restore
                                    </Button>
                                </Tooltip>
                            }
                            <Dialog
                                open={confirmDelete}
                                onClose={closeDialogConfirmDelete}
                                aria-labelledby="alert-dialog-title"
                                aria-describedby="alert-dialog-description">
                                <DialogTitle id="alert-dialog-title">{"Confirm Deletion"}</DialogTitle>
                                <DialogContent>
                                    <DialogContentText id="alert-dialog-description">
                                        Are you sure you want to permanently remove this item?
                                    </DialogContentText>
                                </DialogContent>
                                <DialogActions>
                                    <Button onClick={deletePost} color="default">
                                        OK
                                    </Button>
                                    <Button onClick={closeDialogConfirmDelete} color="primary" autoFocus>
                                        Cancel
                                    </Button>
                                </DialogActions>
                            </Dialog>
                        </>
                    }
                    {
                        data ?
                            data.action === 'ADD_NEW' ?
                                (
                                    checkPermission(postType + '_create') ?
                                        <Button
                                            color="primary"
                                            onClick={handleSubmit}
                                            variant="contained"
                                            startIcon={showLoadingButton ? <CircularProgress size={24} color={'inherit'} /> : null}
                                        >
                                            Publish
                                        </Button>
                                        : null
                                )
                                :
                                (
                                    checkPermission(postType + '_edit') ?
                                        <>
                                            <Button onClick={(e) => { data.post._copy = true; handleSubmit(); }} variant="contained" style={{ marginRight: 8 }}>Copy</Button>
                                            <Button
                                                color="primary"
                                                onClick={handleSubmit}
                                                variant="contained"
                                                startIcon={showLoadingButton ? <CircularProgress size={24} color={'inherit'} /> : null}
                                            >
                                                Update
                                            </Button>
                                        </>
                                        : null
                                )
                            :
                            <></>

                    }
                    {
                        !Boolean(hiddenAddButton) &&
                        <Tooltip title="Add new" aria-label="add-new">
                            <Link to={`/post-type/${postType}/new`}>
                                <Fab style={{ marginLeft: 8 }} size="small" color="primary" aria-label="add">
                                    <AddRoundedIcon />
                                </Fab>
                            </Link>
                        </Tooltip>
                    }
                    {Loading}
                </Grid>
            </Grid>
            <Divider className={classes.divider} />
        </div >
    )
}

export default Header
