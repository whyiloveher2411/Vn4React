import {
    Box, ListItemIcon,
    ListItemText,
    Tooltip
} from "@material-ui/core";
import ClickAwayListener from "@material-ui/core/ClickAwayListener";
import Grow from "@material-ui/core/Grow";
import IconButton from "@material-ui/core/IconButton";
import MenuItem from "@material-ui/core/MenuItem";
import MenuList from "@material-ui/core/MenuList";
import Paper from "@material-ui/core/Paper";
import Popper from "@material-ui/core/Popper";
import { makeStyles } from "@material-ui/core/styles";
import Typography from "@material-ui/core/Typography";
import { changeLanguage } from "actions/language";
import { login, logout } from "actions/user";
import { toogleViewMode } from "actions/viewMode";
import { AvatarCustom, Divider, MaterialIcon } from 'components';
import React from "react";
import { useDispatch, useSelector } from "react-redux";
import { Link } from "react-router-dom";
import { getLanguages, init, __ } from "utils/i18n";
import { useAjax } from "utils/useAjax";

const useStyles = makeStyles((theme) => ({
    small: {
        width: "28px",
        height: "28px",
        fontSize: 13,
        backgroundColor: theme.palette.buttonSave.main
    },
    menuAccount: {
        minWidth: 280,
        maxWidth: '100%',
        maxHeight: '78vh',
        overflowY: 'auto'
    },
    menuItem: {
        minHeight: 36
    }
}));


function Account(props) {

    const user = useSelector((state) => state.user);

    const language = useSelector(state => state.language);

    const theme = useSelector(state => state.theme);

    const classes = useStyles();

    const dispatch = useDispatch();

    const [open, setOpen] = React.useState(false);

    const [openLanguage, setOpenLanguage] = React.useState(false);

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

    // const prevOpen = React.useRef(open);

    const { onOpenNavBarMobile, className, handleRefreshWebsite, ...rest } = props;

    // React.useEffect(() => {
    //     if (prevOpen.current === true && open === false) {
    //         anchorRef.current.focus();
    //     }
    //     prevOpen.current = open;
    // }, [open]);

    const renderMenu = (
        <Popper
            style={{ zIndex: 999 }}
            open={!openLanguage && open}
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
                    <Paper className={classes.menuAccount + ' custom_scroll'}>
                        <ClickAwayListener onClickAway={handleClose}>
                            <MenuList
                                autoFocusItem={open}
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
                                            <Typography variant="body2">{__("Manage your Account")}</Typography>
                                        </div>
                                    </Box>
                                </MenuItem>
                                <Divider style={{ margin: '8px 0' }} color="dark" />


                                <MenuItem
                                    className={classes.menuItem}
                                    onClick={handleUpdateViewMode}>
                                    <ListItemIcon>
                                        <MaterialIcon icon={theme.type === 'light' ? { custom: '<path d="M12 9c1.65 0 3 1.35 3 3s-1.35 3-3 3-3-1.35-3-3 1.35-3 3-3m0-2c-2.76 0-5 2.24-5 5s2.24 5 5 5 5-2.24 5-5-2.24-5-5-5zM2 13h2c.55 0 1-.45 1-1s-.45-1-1-1H2c-.55 0-1 .45-1 1s.45 1 1 1zm18 0h2c.55 0 1-.45 1-1s-.45-1-1-1h-2c-.55 0-1 .45-1 1s.45 1 1 1zM11 2v2c0 .55.45 1 1 1s1-.45 1-1V2c0-.55-.45-1-1-1s-1 .45-1 1zm0 18v2c0 .55.45 1 1 1s1-.45 1-1v-2c0-.55-.45-1-1-1s-1 .45-1 1zM5.99 4.58c-.39-.39-1.03-.39-1.41 0-.39.39-.39 1.03 0 1.41l1.06 1.06c.39.39 1.03.39 1.41 0s.39-1.03 0-1.41L5.99 4.58zm12.37 12.37c-.39-.39-1.03-.39-1.41 0-.39.39-.39 1.03 0 1.41l1.06 1.06c.39.39 1.03.39 1.41 0 .39-.39.39-1.03 0-1.41l-1.06-1.06zm1.06-10.96c.39-.39.39-1.03 0-1.41-.39-.39-1.03-.39-1.41 0l-1.06 1.06c-.39.39-.39 1.03 0 1.41s1.03.39 1.41 0l1.06-1.06zM7.05 18.36c.39-.39.39-1.03 0-1.41-.39-.39-1.03-.39-1.41 0l-1.06 1.06c-.39.39-.39 1.03 0 1.41s1.03.39 1.41 0l1.06-1.06z"></path>' } : 'Brightness2Outlined'} />
                                    </ListItemIcon>
                                    <Typography variant="inherit" noWrap>{__("Appearance")}: {theme.type === 'dark' ? __('Dark') : __('Light')}</Typography>
                                </MenuItem>

                                <MenuItem
                                    className={classes.menuItem}
                                    onClick={() => setOpenLanguage(true)}>
                                    <ListItemIcon>
                                        <MaterialIcon icon={'Translate'} />
                                    </ListItemIcon>
                                    <Typography variant="inherit" noWrap>{__("Language")}: {language.label}</Typography>
                                </MenuItem>

                                <Divider style={{ margin: '8px 0' }} color="dark" />

                                <MenuItem
                                    className={classes.menuItem}
                                    onClick={() => alert('Coming soon!')}>
                                    <ListItemIcon>
                                        <MaterialIcon icon={'HelpOutlineOutlined'} />
                                    </ListItemIcon>
                                    <Typography variant="inherit" noWrap>{__("Help & Support")}</Typography>
                                </MenuItem>

                                <MenuItem
                                    className={classes.menuItem}
                                    onClick={() => alert('Coming soon!')}>
                                    <ListItemIcon>
                                        <MaterialIcon icon={'SmsFailedOutlined'} />
                                    </ListItemIcon>
                                    <ListItemText>
                                        <Typography variant="inherit" noWrap>{__("Send feedback")}</Typography>
                                        <Typography variant="body2">{__("Help us improve the new CMS")}</Typography>
                                    </ListItemText>
                                </MenuItem>
                                <Divider style={{ margin: '8px 0' }} color="dark" />
                                <MenuItem
                                    className={classes.menuItem}
                                    onClick={handleLogout}>
                                    <ListItemIcon>
                                        <MaterialIcon icon={{ custom: '<g><rect fill="none" height="24" width="24" /></g><g><path d="M11,7L9.6,8.4l2.6,2.6H2v2h10.2l-2.6,2.6L11,17l5-5L11,7z M20,19h-8v2h8c1.1,0,2-0.9,2-2V5c0-1.1-0.9-2-2-2h-8v2h8V19z" /></g>' }} />
                                    </ListItemIcon>
                                    <Typography variant="inherit" noWrap>{__("Sign out")}</Typography>
                                </MenuItem>
                            </MenuList>
                        </ClickAwayListener>
                    </Paper>
                </Grow>
            )}
        </Popper>
    );

    const languages = getLanguages();

    const renderMenuLanguage = (
        <Popper
            style={{ zIndex: 999 }}
            open={openLanguage}
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
                    <Paper className={classes.menuAccount + ' custom_scroll'}>
                        <ClickAwayListener onClickAway={() => {
                            setOpenLanguage(false);
                            setOpen(false);
                        }}>
                            <MenuList
                                autoFocusItem={open}
                            >
                                <MenuItem
                                    onClick={() => {
                                        setOpenLanguage(false);
                                        setOpen(true);
                                    }}
                                >
                                    <Box display="flex" width={1} gridGap={16} alignItems="center">
                                        <IconButton>
                                            <MaterialIcon icon="ArrowBackOutlined" />
                                        </IconButton>
                                        <Typography variant="h5" style={{ fontWeight: 'normal' }}>{__("Choose your language")}</Typography>
                                    </Box>
                                </MenuItem>
                                <Divider style={{ margin: '8px 0' }} color="dark" />

                                {
                                    languages.map(option => (
                                        <MenuItem
                                            key={option.code}
                                            className={classes.menuItem}
                                            selected={option.code === language.code}
                                            onClick={() => {
                                                if (option.code !== language.code) {
                                                    dispatch(changeLanguage(option));
                                                    dispatch(login({ ...user })); //Refresh website
                                                }
                                            }}>
                                            <ListItemIcon>
                                                <img
                                                    loading="lazy"
                                                    width="20"
                                                    src={`https://flagcdn.com/w20/${option.flag.toLowerCase()}.png`}
                                                    srcSet={`https://flagcdn.com/w40/${option.flag.toLowerCase()}.png 2x`}
                                                    alt=""
                                                />
                                            </ListItemIcon>
                                            <Box width={1} display="flex" justifyContent="space-between" alignItems="center">
                                                <Typography variant="inherit" noWrap>
                                                    {option.label} {option.note && '(' + option.note + ')'}
                                                </Typography>
                                                {
                                                    option.code === language.code && <MaterialIcon icon="Check" />
                                                }
                                            </Box>
                                        </MenuItem>
                                    ))
                                }

                            </MenuList>
                        </ClickAwayListener>
                    </Paper>
                </Grow>
            )
            }
        </Popper >
    );

    const handleUpdateViewMode = () => {
        dispatch(toogleViewMode());
    }

    return (
        <>
            <Tooltip title={__("Account")}>
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
            {renderMenuLanguage}
            {renderMenu}
        </>
    )
}

export default Account