import {
    Box, ListItemIcon,
    ListItemText,
    Tooltip,
    colors
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
import { changeMode, changeColorPrimary, changeColorSecondary } from "actions/viewMode";
import { AvatarCustom, Divider, MaterialIcon } from 'components';
import React from "react";
import { useDispatch, useSelector } from "react-redux";
import { Link } from "react-router-dom";
import { getLanguages, __ } from "utils/i18n";
import { colorsSchema, themes, shadeColor } from 'utils/viewMode';

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
        maxHeight: '80vh',
        overflowY: 'auto'
    },
    menuItem: {
        minHeight: 36
    },
    colorItem: {
        width: 48,
        height: 48,
        backgroundColor: 'var(--main)',
        cursor: 'pointer',
        '& .MuiIconButton-root': {
            color: 'white',
        }
    },
    colorItemSelected: {
        border: '1px solid ' + theme.palette.text.primary,
    }
}));

function Account(props) {

    const user = useSelector((state) => state.user);

    const language = useSelector(state => state.language);

    const theme = useSelector(state => state.theme);

    const classes = useStyles();

    const dispatch = useDispatch();

    const [open, setOpen] = React.useState(false);

    const anchorRef = React.useRef(null);

    const handleToggle = () => {
        setOpen((prevOpen) => prevOpen === false ? 'account' : false);
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
            open={open === 'account'}
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
                                autoFocusItem={open === 'account'}
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
                                    onClick={() => setOpen('theme')}>
                                    <ListItemIcon>
                                        <MaterialIcon icon={themes[theme.type]?.icon} />
                                    </ListItemIcon>
                                    <Typography variant="inherit" noWrap>{__("Appearance")}: {theme.type === 'dark' ? __('Dark') : __('Light')}</Typography>
                                </MenuItem>

                                <MenuItem
                                    className={classes.menuItem}
                                    onClick={() => setOpen('languages')}>
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
            open={open === 'languages'}
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
                            setOpen(false);
                        }}>
                            <MenuList
                                autoFocusItem={open === 'languages'}
                            >
                                <MenuItem
                                    onClick={() => {
                                        setOpen('account');
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

    const renderMenuTheme = (
        <Popper
            style={{ zIndex: 999 }}
            open={open === 'theme'}
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
                            setOpen(false);
                        }}>
                            <MenuList
                                autoFocusItem={open === 'theme'}
                                style={{ maxWidth: 288 }}
                            >
                                <MenuItem
                                    onClick={() => setOpen('account')}
                                >
                                    <Box display="flex" width={1} gridGap={16} alignItems="center">
                                        <IconButton>
                                            <MaterialIcon icon="ArrowBackOutlined" />
                                        </IconButton>
                                        <Typography variant="h5" style={{ fontWeight: 'normal' }}>{__('Appearance')}</Typography>
                                    </Box>
                                </MenuItem>
                                <Divider style={{ margin: '8px 0' }} color="dark" />
                                <MenuItem disabled style={{ opacity: .7 }}>
                                    <ListItemText>
                                        <Typography disabled variant="inherit" style={{ whiteSpace: 'break-spaces' }}>{__('Setting applies to this browser only')}</Typography>
                                    </ListItemText>
                                </MenuItem>
                                {
                                    Object.keys(themes).map(key => (
                                        <MenuItem
                                            className={classes.menuItem}
                                            key={key}
                                            selected={theme.type === key}
                                            onClick={handleUpdateViewMode(key)}
                                        >
                                            <ListItemIcon>
                                                <MaterialIcon icon={themes[key].icon} />
                                            </ListItemIcon>
                                            <Box width={1} display="flex" justifyContent="space-between" alignItems="center">
                                                <Typography variant="inherit" noWrap>{__('Appearance')} {themes[key].title}</Typography>
                                                {
                                                    theme.type === key && <MaterialIcon icon="Check" />
                                                }
                                            </Box>
                                        </MenuItem>
                                    ))
                                }
                                <Divider style={{ margin: '8px 0' }} color="dark" />
                                <Box paddingLeft={3} paddingRight={3}>
                                    <Typography >{__('Primary')}</Typography>
                                    <Box marginTop={1} maxWidth={'100%'} display="flex" flexWrap="wrap">
                                        {
                                            Object.keys(colorsSchema).map(key => (
                                                <div onClick={handleChangeColorPrimary(key)} key={key} className={classes.colorItem + ' ' + (theme.primaryColor === key ? classes.colorItemSelected : '')} style={{ '--dark': colors[key][shadeColor.primary.dark], '--main': colors[key][shadeColor.primary.main], '--light': colors[key][shadeColor.primary.light] }}>
                                                    {
                                                        theme.primaryColor === key &&
                                                        <IconButton>
                                                            <MaterialIcon icon="Check" />
                                                        </IconButton>
                                                    }
                                                </div>
                                            ))
                                        }
                                    </Box>
                                </Box>
                                <Box padding={[1, 3, 1, 3]}>
                                    <Typography >{__('Secondary')}</Typography>
                                    <Box marginTop={1} maxWidth={'100%'} display="flex" flexWrap="wrap">
                                        {
                                            Object.keys(colorsSchema).map(key => (
                                                <div onClick={handleChangeColorSecondary(key)} key={key} className={classes.colorItem + ' ' + (theme.secondaryColor === key ? classes.colorItemSelected : '')} style={{ '--dark': colors[key][shadeColor.secondary.dark], '--main': colors[key][shadeColor.secondary.main], '--light': colors[key][shadeColor.secondary.light] }}>
                                                    {
                                                        theme.secondaryColor === key &&
                                                        <IconButton>
                                                            <MaterialIcon icon="Check" />
                                                        </IconButton>
                                                    }
                                                </div>
                                            ))
                                        }
                                    </Box>
                                </Box>
                            </MenuList>

                        </ClickAwayListener>
                    </Paper>
                </Grow>
            )
            }
        </Popper >
    );

    const handleUpdateViewMode = (mode) => () => {
        dispatch(changeMode(mode));
    }

    const handleChangeColorPrimary = (colorKey) => () => {
        dispatch(changeColorPrimary(colorKey));
    }

    const handleChangeColorSecondary = (colorKey) => () => {
        dispatch(changeColorSecondary(colorKey));
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
            {renderMenuTheme}
        </>
    )
}

export default Account