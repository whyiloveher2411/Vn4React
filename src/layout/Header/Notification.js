import {
    Badge,
    Box, List,
    ListItem, ListItemText,
    Tooltip
} from "@material-ui/core";
import ClickAwayListener from "@material-ui/core/ClickAwayListener";
import IconButton from "@material-ui/core/IconButton";
import Paper from "@material-ui/core/Paper";
import Popper from "@material-ui/core/Popper";
import { makeStyles } from "@material-ui/core/styles";
import Typography from "@material-ui/core/Typography";
import NotificationsNoneOutlinedIcon from '@material-ui/icons/NotificationsNoneOutlined';
import ReplyOutlinedIcon from '@material-ui/icons/ReplyOutlined';
import { Skeleton } from "@material-ui/lab";
import { AvatarCustom, Divider } from 'components';
import React, { useRef, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { Link } from "react-router-dom";
import { __ } from "utils/i18n";
import { useAjax } from "utils/useAjax";

const useStyles = makeStyles((theme) => ({
    searchPopper: {
        zIndex: theme.zIndex.appBar + 100,
    },
    searchPopperContent: {
        marginTop: theme.spacing(1),
        maxHeight: '80vh',
        overflow: 'auto',
        minWidth: 300,
        maxWidth: '100%',
        '& a': {
            color: theme.palette.primary.main
        }
    },
    notification: {
        borderBottom: '1px solid ' + theme.palette.dividerDark,
    },
    notificationIcon: {
        backgroundColor: theme.palette.primary.main,
        marginTop: 4
    },
    notificationTitle: {
        overflow: 'hidden', width: '100%', display: '-webkit-box', WebkitLineClamp: '1', WebkitBoxOrient: 'vertical'
    },
    notificationContent: {
        marginTop: 4, overflow: 'hidden', width: '100%', display: '-webkit-box', WebkitLineClamp: '3', WebkitBoxOrient: 'vertical',
    },
}));

export default function Notification() {

    let settings = useSelector((state) => state.settings);

    const theme = useSelector(state => state.theme);

    const classes = useStyles();

    const dispatch = useDispatch();

    const notificationRef = useRef(null);

    const [openNotifications, setOpenNotifications] = useState(false);

    const useAjax1 = useAjax({ loadingType: 'custom' });
    const useAjax2 = useAjax();

    const [notificationContent, setNotificationContent] = React.useState({});

    const onClickShowNotification = () => {
        if (!openNotifications) {
            setOpenNotifications(true);
            useAjax1.ajax({
                url: 'global/get-notification',
                method: 'POST',
                success: (result) => {
                    if (result.posts) {
                        setNotificationContent(result);
                        updateNotificationLocal(result.posts.total);
                    }
                }
            });
        }
    };

    const updateNotification = () => {
        useAjax2.ajax({
            url: 'global/get-notification',
            method: 'POST',
            data: {
                action: 'updateCount',
            },
            success: (result) => {
                if (result.count) {
                    updateNotificationLocal(result.count);
                }
            }
        });
    };

    const updateNotificationLocal = (count) => {

        if (count !== settings.notification_count) {
            dispatch({
                type: 'SETTINGS_UPDATE',
                payload: {
                    notification_count: count
                }
            });
        }

    };

    React.useEffect(() => {

        updateNotification();
        window.__updateNotification = setInterval(() => {
            updateNotification();
        }, 60000);

        return () => {
            if (window.__updateNotification) {
                clearInterval(window.__updateNotification);
            }
        };
    }, []);

    return (
        <>
            <Tooltip title={__("Notification")}>
                <IconButton
                    color="inherit"
                    onClick={onClickShowNotification}
                    ref={notificationRef}
                >
                    <Badge badgeContent={settings.notification_count ?? 0} max={10} color="secondary">
                        <NotificationsNoneOutlinedIcon />
                    </Badge>
                </IconButton>
            </Tooltip>

            <Popper
                anchorEl={notificationRef.current}
                className={classes.searchPopper}
                open={openNotifications}
                transition
            >
                <ClickAwayListener onClickAway={() => setOpenNotifications(false)}>
                    <Paper style={{ width: 400, maxWidth: '100%' }} className={classes.searchPopperContent + ' custom_scroll'} elevation={3}>
                        <List>
                            {
                                useAjax1.open ?
                                    [1, 2, 3, 4].map(item => (
                                        <ListItem
                                            onClick={() => setOpenNotifications(false)}
                                            className={classes.notification}
                                            key={item}
                                        >
                                            <div style={{ width: '100%' }}>
                                                <Skeleton variant="text" height={20} width="100%" />
                                                <Box display="flex" alignItems="flex-start" gridGap={16}>
                                                    <div style={{ height: '100%' }}>
                                                        <Skeleton variant="circle" width={40} style={{ marginTop: 8 }} height={40} />
                                                    </div>
                                                    <div style={{ width: '100%' }}>
                                                        <Skeleton variant="text" height={22} width="100%" />
                                                        <Skeleton variant="text" style={{ transform: 'scale(1)' }} height={40} width="100%" />
                                                    </div>
                                                </Box>
                                            </div>
                                        </ListItem>
                                    ))
                                    :
                                    Boolean(notificationContent.posts && notificationContent.posts.data && notificationContent.posts.data.length > 0) ?
                                        <>
                                            <Typography style={{ padding: '8px 16px 16px' }} variant="h5">{__("Notifications")}</Typography>
                                            <Divider color="dark" />
                                            {
                                                notificationContent.posts.data.map(item => (
                                                    <Link key={item.id} to={'/post-type/admin_notification/edit?post_id=' + item.id}>
                                                        <ListItem
                                                            onClick={() => setOpenNotifications(false)}
                                                            className={classes.notification}
                                                            key={item.id}
                                                        >
                                                            <Box width={1} display="flex" alignItems="flex-start" gridGap={16} style={{ marginTop: 14 }}>
                                                                <div style={{ height: '100%' }}>
                                                                    <AvatarCustom
                                                                        name={notificationContent.severitys[item.severity]?.title}
                                                                        className={classes.notificationIcon}
                                                                        style={{
                                                                            backgroundColor: notificationContent.severitys[item.severity]?.textColor ?? theme.palette.primary.main
                                                                        }}
                                                                    />
                                                                </div>
                                                                <div style={{ width: '100%' }}>
                                                                    <Typography className={classes.notificationTitle} variant="h5">{item.title}</Typography>
                                                                    <Typography className={classes.notificationContent} variant="body1" >{item.message}</Typography>
                                                                    <Typography variant="body2">{item.created_diffForHumans}</Typography>
                                                                </div>
                                                                <ReplyOutlinedIcon />
                                                            </Box>
                                                        </ListItem>
                                                    </Link>
                                                ))
                                            }
                                            {
                                                notificationContent.posts.data.length > 0 &&
                                                <Link to={'/post-type/admin_notification/list'}>
                                                    <ListItem
                                                        button
                                                        onClick={() => setOpenNotifications(false)}
                                                    >
                                                        <ListItemText align="center" primary={__('See All ({{count}} unread)', { count: notificationContent.posts.total })} />
                                                    </ListItem>
                                                </Link>
                                            }
                                        </>
                                        :
                                        <Link to={'/post-type/admin_notification/list'}>
                                            <ListItem
                                                button
                                                onClick={() => setOpenNotifications(false)}
                                                className={classes.notification}
                                            >
                                                <Typography style={{ width: '100%', padding: '46px 0', fontSize: 20, fontWeight: 100 }} align="center" variant="body1">{__("No messages found")}</Typography>
                                            </ListItem>
                                        </Link>
                            }
                        </List>
                    </Paper>
                </ClickAwayListener>
            </Popper>
        </>
    );
}
