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
import { toogleViewMode } from "actions/viewMode";
import { AvatarCustom, Divider, MaterialIcon } from 'components';
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
  header: {
    background: theme.palette.header.background,
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
  menuAccount: {
    minWidth: 280,
    maxWidth: '100%',
  }
}));

export default function Header(props) {
  let user = useSelector((state) => state.user);
  let settings = useSelector((state) => state.settings);
  const theme = useSelector(state => state.theme);

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
          <Paper className={classes.menuAccount}>
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
                  <Box display="flex" width={1} gridGap={16}>
                    <AvatarCustom
                      image={user.profile_picture}
                      name={user.first_name + ' ' + user.last_name}
                    />
                    <div>
                      <Typography variant="body1">{(user.first_name ?? '') + ' ' + (user.last_name ?? '')}</Typography>
                      <Typography variant="body2">Manage your Account</Typography>
                    </div>
                  </Box>
                </MenuItem>
                <Divider style={{ margin: '8px 0' }} color="dark" />


                <MenuItem onClick={handleUpdateViewMode}>
                  <ListItemIcon>
                    <MaterialIcon icon={theme.type === 'light' ? { custom: '<path d="M12 9c1.65 0 3 1.35 3 3s-1.35 3-3 3-3-1.35-3-3 1.35-3 3-3m0-2c-2.76 0-5 2.24-5 5s2.24 5 5 5 5-2.24 5-5-2.24-5-5-5zM2 13h2c.55 0 1-.45 1-1s-.45-1-1-1H2c-.55 0-1 .45-1 1s.45 1 1 1zm18 0h2c.55 0 1-.45 1-1s-.45-1-1-1h-2c-.55 0-1 .45-1 1s.45 1 1 1zM11 2v2c0 .55.45 1 1 1s1-.45 1-1V2c0-.55-.45-1-1-1s-1 .45-1 1zm0 18v2c0 .55.45 1 1 1s1-.45 1-1v-2c0-.55-.45-1-1-1s-1 .45-1 1zM5.99 4.58c-.39-.39-1.03-.39-1.41 0-.39.39-.39 1.03 0 1.41l1.06 1.06c.39.39 1.03.39 1.41 0s.39-1.03 0-1.41L5.99 4.58zm12.37 12.37c-.39-.39-1.03-.39-1.41 0-.39.39-.39 1.03 0 1.41l1.06 1.06c.39.39 1.03.39 1.41 0 .39-.39.39-1.03 0-1.41l-1.06-1.06zm1.06-10.96c.39-.39.39-1.03 0-1.41-.39-.39-1.03-.39-1.41 0l-1.06 1.06c-.39.39-.39 1.03 0 1.41s1.03.39 1.41 0l1.06-1.06zM7.05 18.36c.39-.39.39-1.03 0-1.41-.39-.39-1.03-.39-1.41 0l-1.06 1.06c-.39.39-.39 1.03 0 1.41s1.03.39 1.41 0l1.06-1.06z"></path>' } : 'Brightness2Outlined'} />
                  </ListItemIcon>
                  <Typography variant="inherit" noWrap>Appearance: {theme.type === 'dark' ? 'Dark' : 'Light'}</Typography>
                </MenuItem>

                <MenuItem onClick={() => alert('Coming soon!')}>
                  <ListItemIcon>
                    <MaterialIcon icon={'LanguageRounded'} />
                  </ListItemIcon>
                  <Typography variant="inherit" noWrap>Language: English</Typography>
                </MenuItem>

                <Divider style={{ margin: '8px 0' }} color="dark" />

                <MenuItem onClick={() => alert('Coming soon!')}>
                  <ListItemIcon>
                    <MaterialIcon icon={'HelpOutlineOutlined'} />
                  </ListItemIcon>
                  <Typography variant="inherit" noWrap>Help & Support</Typography>
                </MenuItem>

                <MenuItem onClick={() => alert('Coming soon!')}>
                  <ListItemIcon>
                    <MaterialIcon icon={'SmsFailedOutlined'} />
                  </ListItemIcon>
                  <ListItemText>
                    <Typography variant="inherit" noWrap>Send feedback</Typography>
                    <Typography variant="body2">Help us improve the new CMS</Typography>
                  </ListItemText>
                </MenuItem>


                <Divider style={{ margin: '8px 0' }} color="dark" />

                <MenuItem onClick={handleLogout}>
                  <ListItemIcon>
                    <MaterialIcon icon={{ custom: '<g><rect fill="none" height="24" width="24" /></g><g><path d="M11,7L9.6,8.4l2.6,2.6H2v2h10.2l-2.6,2.6L11,17l5-5L11,7z M20,19h-8v2h8c1.1,0,2-0.9,2-2V5c0-1.1-0.9-2-2-2h-8v2h8V19z" /></g>' }} />
                  </ListItemIcon>
                  <Typography variant="inherit" noWrap>Sign out</Typography>
                </MenuItem>
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

  const handleUpdateViewMode = () => {
    dispatch(toogleViewMode());
  }

  return (
    <div className={classes.root}>
      <AppBar className={classes.header} position="static">
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
                            <Typography style={{ padding: '8px 16px 16px' }} variant="h5">Notifications</Typography>
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
                  name={user.first_name + ' ' + user.last_name}
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
