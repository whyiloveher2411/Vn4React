import { Box, CircularProgress, IconButton, ListItemIcon, makeStyles, Tooltip } from '@material-ui/core';
import ClickAwayListener from "@material-ui/core/ClickAwayListener";
import Grow from "@material-ui/core/Grow";
import MenuItem from "@material-ui/core/MenuItem";
import MenuList from "@material-ui/core/MenuList";
import Paper from "@material-ui/core/Paper";
import Popper from "@material-ui/core/Popper";
import Typography from "@material-ui/core/Typography";
import { Divider } from 'components';
import MaterialIcon from 'components/MaterialIcon';
import { clearCache } from 'page/OnePage/Tool/cacheAction';
import { backupDatabase, checkDatabase } from 'page/OnePage/Tool/databaseAction';
import { checkLanguage, compileCodeDI, deployAsset, refreshView } from 'page/OnePage/Tool/developmentAction';
import { minifyHTML } from 'page/OnePage/Tool/optimizeAction';
import React from 'react';
import { getLanguages, __ } from 'utils/i18n';
import { MODE, useSetting } from 'utils/settings';
import { useAjax } from 'utils/useAjax';

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

const ToolItem = (props) => {
    const ajaxHandle = useAjax();

    const handleClick = () => {
        props.actionFunc(ajaxHandle.ajax, props.dataAction, props.callback);
    };

    return (
        <MenuItem
            style={{ minHeight: 36 }}
            disabled={props.disable}
            onClick={handleClick}>
            <ListItemIcon>
                <MaterialIcon icon={props.icon} />
            </ListItemIcon>
            <Box width={1} display="flex" justifyContent="space-between">
                <Typography variant="inherit" noWrap>{props.title}</Typography>
                {
                    ajaxHandle.open && <CircularProgress size={18} color={'inherit'} />
                }
            </Box>
        </MenuItem>
    )
};

const MenuGroupTool = ({ items, showDivider }) => (
    <>
        {
            items.map((item, index) => (
                <ToolItem key={index} {...item} />
            ))
        }
        {
            showDivider &&
            <Divider style={{ margin: '8px 0' }} color="dark" />
        }
    </>
)

function Tools() {

    const classes = useStyles();

    const [open, setOpen] = React.useState(false);

    const anchorRef = React.useRef(null);

    const mode = useSetting('general_status');

    const handleClose = (event) => {
        if (anchorRef.current && anchorRef.current.contains(event.target)) {
            return;
        }

        setOpen(false);
    };

    function handleListKeyDown(event) {
        if (event.key === "Tab") {
            event.preventDefault();
            setOpen(false);
        }
    }

    const handleToggle = () => {
        setOpen((prevOpen) => !prevOpen);
    };

    const toolList = [
        [
            {
                title: __('Flush Cache'),
                icon: 'DnsOutlined',
                dataAction: 'all',
                actionFunc: clearCache
            },
        ],
        [
            {
                title: __('Check Database'),
                icon: 'StorageOutlined',
                actionFunc: checkDatabase,
                disable: mode !== MODE.DEVELOPING
            },
            {
                title: __('Backup Database'),
                icon: 'BackupOutlined',
                actionFunc: backupDatabase,
                disable: mode !== MODE.DEVELOPING
            }
        ],
        [
            {
                title: __('Deploy static data'),
                icon: 'FileCopyOutlined',
                actionFunc: deployAsset,
                disable: mode !== MODE.DEVELOPING
            },
            {
                title: __('Declare hook'),
                icon: { custom: '<path d="M6 11.09v-4.7l6-2.25 6 2.25v3.69c.71.1 1.38.31 2 .6V5l-8-3-8 3v6.09c0 5.05 3.41 9.76 8 10.91.03-.01.05-.02.08-.02-.79-.78-1.4-1.76-1.75-2.84C7.76 17.53 6 14.42 6 11.09z"></path><path d="M17 12c-2.76 0-5 2.24-5 5s2.24 5 5 5 5-2.24 5-5-2.24-5-5-5zm3 5.5h-2.5V20h-1v-2.5H14v-1h2.5V14h1v2.5H20v1z"></path>' },
                actionFunc: compileCodeDI,
                disable: mode !== MODE.DEVELOPING
            },
            {
                title: __('Refresh views'),
                icon: 'Refresh',
                actionFunc: refreshView,
                disable: mode !== MODE.DEVELOPING
            },
            {
                title: __('Render language'),
                icon: 'TranslateOutlined',
                actionFunc: checkLanguage,
                dataAction: { languages: getLanguages() },
                disable: mode !== MODE.DEVELOPING
            },
        ],
        [
            {
                title: __('Minify HTML'),
                icon: 'CodeOutlined',
                actionFunc: minifyHTML,
                disable: mode !== MODE.DEVELOPING
            }
        ]
    ];

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
                    <Paper className={classes.menuAccount + ' custom_scroll'}>
                        <ClickAwayListener onClickAway={handleClose}>
                            <MenuList
                                autoFocusItem={open}
                                onKeyDown={handleListKeyDown}
                            >
                                {
                                    toolList.map((toolGroup, index) => (
                                        <MenuGroupTool key={index} items={toolGroup} showDivider={index !== toolList.length - 1} />
                                    ))
                                }
                            </MenuList>
                        </ClickAwayListener>
                    </Paper>
                </Grow>
            )}
        </Popper>
    );

    return (
        <>
            <Tooltip title={__('Tools')}>
                <IconButton
                    ref={anchorRef}
                    aria-haspopup="true"
                    color="inherit"
                    onClick={handleToggle}
                >
                    <MaterialIcon icon="SettingsOutlined" />
                </IconButton>
            </Tooltip>
            {renderMenu}
        </>
    )
}

export default Tools
