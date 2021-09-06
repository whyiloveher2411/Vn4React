import { ClickAwayListener, Collapse, List, ListItem, makeStyles, Popover } from '@material-ui/core';
import Divider from '@material-ui/core/Divider';
import ListItemIcon from '@material-ui/core/ListItemIcon';
import ListItemText from '@material-ui/core/ListItemText';
import ArrowRightIcon from '@material-ui/icons/ArrowRight';
import React from 'react';


const useStyles = makeStyles((theme) => ({
    menuFile: {
        userSelect: 'none',
        maxWidth: 400,
        minWidth: 'var(--minWidth)',
        '& .MuiListItem-button': {
            height: 38,
        },
    },
    menuPopover: {
        '& .MuiPopover-paper': {
            transform: 'var(--transform)',
            pointerEvents: 'all',
        }
    },
    itemText: {
        '&>*': {
            display: 'block',
            overflow: 'hidden',
            whiteSpace: 'nowrap',
            textOverflow: 'ellipsis',
        },
    }
}));


function MenuMouseRight(children = 0, params = {}) {

    const classes = useStyles();

    const [anchorEl, setAnchorEl] = React.useState({
        rel: null
    });

    const handelOnClickRight = (e) => {

        e.preventDefault();

        const target = e.currentTarget;

        // Get the bounding rectangle of target
        const rect = target.getBoundingClientRect();

        let x;
        let y;

        // Mouse position
        if (children) {
            x = y = 0;
        } else {
            x = e.clientX - rect.left + 2;
            y = rect.height - (e.clientY - rect.top);
        }

        if (!window.__mouseRightFileMange) window.__mouseRightFileMange = {};

        if (window.__mouseRightFileMange['level_' + children]) {
            window.__mouseRightFileMange['level_' + children]();
        }

        window.__mouseRightFileMange['level_' + children] = handleClose;

        setAnchorEl({
            rel: e.currentTarget,
            transform: 'translate(' + x + 'px, -' + y + 'px)'
        });

    }

    React.useEffect(() => {
        if (window.__mouseRightFileMange && window.__mouseRightFileMange['level_' + (children + 1)]) {
            window.__mouseRightFileMange['level_' + (children + 1)]();
            delete window.__mouseRightFileMange['level_' + (children + 1)];
        }
    }, []);

    const handleClose = () => {
        // if (!children) {
        delete window.__mouseRightFileMange['level_' + children];
        setAnchorEl(prev => ({
            ...prev,
            rel: null,
        }));
        // }
    };

    const transformOrigin = children ? {
        transformOrigin: {
            vertical: 'top',
            horizontal: 'left',
        },
        anchorOrigin: {
            vertical: 'top',
            horizontal: 'right',
        },
    } : {
        transformOrigin: {
            vertical: 'top',
            horizontal: 'left',
        },
        anchorOrigin: {
            vertical: 'bottom',
            horizontal: 'left',
        },
    }

    return {
        anchorProps: {
            onContextMenu: handelOnClickRight
        },
        anchorEl: anchorEl,
        menu: (listMenu) => {

            if (anchorEl.ref !== null) {
                return <ClickAwayListener onClickAway={!children ? handleClose : () => {

                }} >
                    <Popover
                        anchorEl={anchorEl.rel}
                        onClose={handleClose}
                        open={Boolean(anchorEl.rel)}
                        TransitionComponent={Collapse}
                        className={classes.menuPopover}
                        {...transformOrigin}
                        style={{ pointerEvents: 'none', '--transform': anchorEl.transform, '--minWidth': params.minWidth ?? '320px' }}

                    >
                        {
                            listMenu.map((menu, index) => (
                                <React.Fragment key={index}>
                                    <List className={classes.menuFile} component="nav" aria-label="main mailbox folders">
                                        {
                                            Object.keys(menu).map(key => {

                                                if (menu[key].hidden) {
                                                    return <React.Fragment key={key}></React.Fragment>
                                                }

                                                let childrenMenu;
                                                let propsMenuItem = {};

                                                if (menu[key].children) {
                                                    const MenuMouseRight2 = MenuMouseRight(children + 1, { minWidth: menu[key].minWidth ?? '320px' });
                                                    propsMenuItem = { ...MenuMouseRight2.anchorProps, onClick: MenuMouseRight2.anchorProps.onContextMenu }
                                                    childrenMenu = <React.Fragment key={key}><ArrowRightIcon />{MenuMouseRight2.menu(menu[key].children)}</React.Fragment>;
                                                }

                                                if (menu[key].component) {
                                                    return <React.Fragment key={key}>{menu[key].component}</React.Fragment>;
                                                }

                                                return <ListItem key={key} button
                                                    {...menu[key].action}
                                                    {...propsMenuItem}
                                                    onClick={(e) => {
                                                        if (window.__mouseRightFileMange['level_' + (children + 1)]) {
                                                            window.__mouseRightFileMange['level_' + (children + 1)]();
                                                        }
                                                        if (menu[key].action && menu[key].action.onClick) {
                                                            menu[key].action.onClick(e);
                                                        }
                                                        if (propsMenuItem.onClick) {
                                                            propsMenuItem.onClick(e);
                                                        }
                                                    }}
                                                >
                                                    {
                                                        Boolean(menu[key].icon) &&
                                                        <ListItemIcon>
                                                            {menu[key].icon}
                                                        </ListItemIcon>
                                                    }
                                                    <ListItemText className={classes.itemText} primary={menu[key].title} />
                                                    {childrenMenu}
                                                </ListItem>
                                            })
                                        }
                                    </List>
                                    <Divider />
                                </React.Fragment>
                            ))
                        }
                    </Popover>
                </ClickAwayListener >
            } else {
                return null;
            }
        }
    }
}

export default MenuMouseRight
