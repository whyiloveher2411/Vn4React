import {
  Badge,
  Box, Input,
  List,
  ListItem,
  ListItemIcon,
  ListItemText,
  Tooltip
} from "@material-ui/core";
import AppBar from "@material-ui/core/AppBar";
import ClickAwayListener from "@material-ui/core/ClickAwayListener";
import Grow from "@material-ui/core/Grow";
import IconButton from "@material-ui/core/IconButton";
import MenuItem from "@material-ui/core/MenuItem";
import MenuList from "@material-ui/core/MenuList";
import Paper from "@material-ui/core/Paper";
import Popper from "@material-ui/core/Popper";
import { makeStyles } from "@material-ui/core/styles";
import Toolbar from "@material-ui/core/Toolbar";
import Typography from "@material-ui/core/Typography";
import AppsIcon from '@material-ui/icons/Apps';
import ChatIcon from '@material-ui/icons/Chat';
import NotificationsNoneOutlinedIcon from '@material-ui/icons/NotificationsNoneOutlined';
import RefreshRoundedIcon from '@material-ui/icons/RefreshRounded';
import ReplyOutlinedIcon from '@material-ui/icons/ReplyOutlined';
import SearchIcon from "@material-ui/icons/Search";
import { Skeleton } from "@material-ui/lab";
import { AvatarCustom } from 'components';
import React, { useRef, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { Link, useHistory } from "react-router-dom";
import { useAjax } from "utils/useAjax";
import { login, logout } from "../actions/user";

const useStyles = makeStyles((theme) => ({
  small: {
    width: "28px",
    height: "28px",
    fontSize: 13,
    backgroundColor: theme.palette.buttonSave.main
  },
  grow: {
    flexGrow: 1,
  },
  title: {
    display: "block",
    [theme.breakpoints.down("xs")]: {
      display: "none",
    },
    color: theme.palette.white,
  },
  sectionDesktop: {
    display: "flex",
  },
  root: {
    boxShadow: "none",
    zIndex: 99,
  },
  search: {
    backgroundColor: "rgba(255,255,255, 0.1)",
    borderRadius: 4,
    flexBasis: 300,
    height: 36,
    padding: theme.spacing(0, 2),
    display: "flex",
    alignItems: "center",
    marginLeft: theme.spacing(2),
    [theme.breakpoints.down("xs")]: {
      display: "none",
    },
  },
  searchIcon: {
    marginRight: theme.spacing(2),
    color: "inherit",
  },
  searchInput: {
    flexGrow: 1,
    color: "inherit",
    "& input::placeholder": {
      opacity: 1,
      color: "inherit",
    },
  },
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
    borderBottom: '1px solid #dedede',
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
    opacity: .8,
  }
}));

export default function Header(props) {
  let user = useSelector((state) => state.user);
  let settings = useSelector((state) => state.settings);

  const history = useHistory();

  const classes = useStyles();

  const dispatch = useDispatch();

  const [open, setOpen] = React.useState(false);
  const anchorRef = React.useRef(null);

  const handleToggle = () => {
    setOpen((prevOpen) => !prevOpen);
  };

  const handleClose = (event) => {
    if (anchorRef.current && anchorRef.current.contains(event.target)) {
      return;
    }

    setOpen(false);
  };

  const handleLogout = () => {
    dispatch(logout());
    setOpen(false);
  };

  function handleListKeyDown(event) {
    if (event.key === "Tab") {
      event.preventDefault();
      setOpen(false);
    }
  }

  const prevOpen = React.useRef(open);

  const { onOpenNavBarMobile, className, ...rest } = props;

  const searchRef = useRef(null);
  const notificationRef = useRef(null);
  const [openSearchPopover, setOpenSearchPopover] = useState(false);

  const [openNotifications, setOpenNotifications] = useState(false);

  const [searchValue, setSearchValue] = useState("");

  const useAjax1 = useAjax({ loadingType: 'custom' });

  const [popularSearches, setPopularSearches] = React.useState([]);

  const handleSearchkeypress = (event) => {
    // if (event.target.value) {
    useAjax1.ajax({
      url: "search/get",
      method: "POST",
      isGetData: false,
      data: {
        search: event.target.value,
      },
      success: (result) => {
        if (result.data && result.data.length) {
          setOpenSearchPopover(true);
          setPopularSearches(result.data);
        } else {
          setOpenSearchPopover(true);
          setPopularSearches([
            { title: 'Data not found.' }
          ]);
        }
      },
    });
  };

  const handleSearchChange = (event) => {
    setSearchValue(event.target.value);
  };

  const handleSearchPopverClose = () => {
    setOpenSearchPopover(false);
  };

  React.useEffect(() => {
    if (prevOpen.current === true && open === false) {
      anchorRef.current.focus();
    }
    prevOpen.current = open;
  }, [open]);

  const renderMenu = (
    <Popper
      style={{ zIndex: 999 }}
      open={open}
      anchorEl={anchorRef.current}
      transition
    >
      {({ TransitionProps, placement }) => (
        <Grow
          {...TransitionProps}
          style={{
            transformOrigin:
              placement === "bottom" ? "center top" : "center bottom",
          }}
        >
          <Paper>
            <ClickAwayListener onClickAway={handleClose}>
              <MenuList
                autoFocusItem={open}
                id="menu-list-grow"
                onKeyDown={handleListKeyDown}
              >
                <MenuItem
                  component={Link}
                  to="/users/profile/general"
                  onClick={handleClose}
                >
                  Profile
                </MenuItem>
                <MenuItem onClick={handleLogout}>Logout</MenuItem>
              </MenuList>
            </ClickAwayListener>
          </Paper>
        </Grow>
      )}
    </Popper>
  );

  const handleRefreshWebsite = () => {

    useAjax1.ajax({
      url: "global/refresh",
      method: "POST",
      success: (result) => {

        if (result.sidebar) {
          dispatch(
            {
              type: 'SIDEBAR_UPDATE',
              payload: result.sidebar
            }
          );
        }

        dispatch(login({ ...user }))
      }
    });

  }

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

  const useAjax2 = useAjax();

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
    <div className={classes.root}>
      <AppBar position="static">
        <Toolbar>
          <Link to="/">
            <Typography className={classes.title} variant="h2" noWrap>
              Biong
            </Typography>
          </Link>

          <div className={classes.search} ref={searchRef}>
            <SearchIcon className={classes.searchIcon} />
            <Input
              className={classes.searchInput}
              disableUnderline
              onKeyPress={(e) => {
                if (e.which === 13) handleSearchkeypress(e);
              }}
              onChange={handleSearchChange}
              placeholder="Enter something..."
              value={searchValue}
            />
          </div>

          <Popper
            anchorEl={searchRef.current}
            className={classes.searchPopper}
            open={openSearchPopover}
            transition
          >
            <ClickAwayListener onClickAway={handleSearchPopverClose}>
              <Paper className={classes.searchPopperContent + ' custom_scroll'} elevation={3}>
                <List>
                  {popularSearches.map((search, index) => (
                    <Link key={search.link} to={search.link}>
                      <ListItem
                        button
                        onClick={handleSearchPopverClose}
                      >
                        <ListItemIcon>
                          <SearchIcon />
                        </ListItemIcon>
                        <ListItemText primary={search.title_type ? '[' + search.title_type + '] ' + search.title : search.title} />
                      </ListItem>
                    </Link>
                  ))}
                </List>
              </Paper>
            </ClickAwayListener>
          </Popper>

          <div className={classes.grow} />
          <div className={classes.sectionDesktop}>


            <Tooltip title="Refesh">
              <IconButton
                edge="start"
                color="inherit"
                onClick={handleRefreshWebsite}
              >
                <RefreshRoundedIcon />
              </IconButton>
            </Tooltip>

            <Tooltip title="Notification">
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
                            {
                              notificationContent.posts.data.map(item => (
                                <Link key={item.id} to={'/post-type/admin_notification/edit?post_id=' + item.id}>
                                  <ListItem
                                    onClick={() => setOpenNotifications(false)}
                                    className={classes.notification}
                                    key={item.id}
                                  >
                                    <div style={{ width: '100%' }}>
                                      <Box width={1} display="flex" gridGap={8} >
                                        <Box display="flex" alignItems="center" gridGap={3}>
                                          <ChatIcon fontSize='small' />
                                          {notificationContent.severitys[item.severity] ?
                                            <Typography variant="body1" style={{ color: notificationContent.severitys[item.severity].textColor }}>{notificationContent.severitys[item.severity].title}</Typography>
                                            : ''}
                                        </Box>
                                        {
                                          Boolean(item.host) &&
                                          <>
                                            ● <Typography variant="body1">{item.host}</Typography>
                                          </>
                                        }

                                        ● <Typography variant="body1">{item.created_diffForHumans}</Typography>
                                      </Box>
                                      <Box width={1} display="flex" alignItems="flex-start" gridGap={16} style={{ marginTop: 14 }}>
                                        <div style={{ height: '100%' }}>
                                          <AvatarCustom
                                            name={'B'}
                                            className={classes.notificationIcon}
                                          />
                                        </div>
                                        <div style={{ width: '100%' }}>
                                          <Typography className={classes.notificationTitle} variant="h5">{item.title}</Typography>
                                          <Typography className={classes.notificationContent} variant="body1" >{item.message}</Typography>
                                        </div>
                                        <ReplyOutlinedIcon />
                                      </Box>
                                    </div>
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
                                  <ListItemText align="center" primary={'See All (' + notificationContent.posts.total + ' unread)'} />
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
                              <Typography style={{ width: '100%', padding: '46px 0', fontSize: 20 }} align="center" variant="body1">No messages found</Typography>
                            </ListItem>
                          </Link>
                    }



                  </List>
                </Paper>
              </ClickAwayListener>
            </Popper>

            <Tooltip title="Apps">
              <IconButton
                color="inherit"
                onClick={() => history.push('/coming-soon')}
              >
                <AppsIcon />
              </IconButton>
            </Tooltip>

            <Tooltip title="Account">
              <IconButton
                edge="end"
                color="inherit"
                ref={anchorRef}
                aria-controls={open ? "menu-list-grow" : undefined}
                aria-haspopup="true"
                onClick={handleToggle}
              >
                <AvatarCustom
                  image={user.profile_picture}
                  name={user.first_name + ' ' + user.lastname}
                  className={classes.small}
                />
              </IconButton>
            </Tooltip>
          </div>
        </Toolbar>
      </AppBar>
      {renderMenu}
    </div>
  );
}
