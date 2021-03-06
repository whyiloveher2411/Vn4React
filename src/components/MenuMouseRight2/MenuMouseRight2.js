import { ClickAwayListener, Collapse, List, ListItem, makeStyles, Popover } from '@material-ui/core';
import Divider from '@material-ui/core/Divider';
import ListItemIcon from '@material-ui/core/ListItemIcon';
import ListItemText from '@material-ui/core/ListItemText';
import React from 'react';
import ArrowRightIcon from '@material-ui/icons/ArrowRight';


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
            pointerEvents: 'all'
        }
    },
    notMenuChildren: {
        '& .MuiPopover-paper': {
            pointerEvents: 'all',
            top: 'var(--top) !important',
            left: 'var(--left) !important',
            transform: 'var(--translate)',
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


function MenuMouseRight({ childrenLevel = 0, component = 'div', minWidth, listMenu, ...rest }) {

    const classes = useStyles();

    const [anchorEl, setAnchorEl] = React.useState({
        open: false,
        rel: null
    });

    const handelOnClickRight = (e) => {

        e.preventDefault();
        e.stopPropagation();

        const target = e.currentTarget;

        // Get the bounding rectangle of target
        const rect = target.getBoundingClientRect();

        let x;
        let y;
        let translate = 'translate(0, 0)';
        let translateX = 0;
        let translateY = 0;
        // Mouse position
        if (childrenLevel) {

            x = y = 0;

        } else {


            if (window.innerWidth - e.clientX > 400) {
                x = e.pageX + 1 + 'px';
            } else {
                x = e.pageX + 'px';
                translateX = 102 - ((window.innerWidth - e.clientX) * 100) / 400;
            }

            if (window.innerHeight - e.clientY > 450) {
                y = e.pageY + 'px';
            } else {
                y = e.pageY + 'px';
                translateY = 102 - ((window.innerHeight - e.clientY) * 100) / 450;
            }

            translate = 'translate(-' + Math.round(translateX) + '%, -' + Math.round(translateY) + '%)';


            // x = e.clientX - rect.left + 2;

            // if ((window.innerHeight - 100) > 500) {
            //     y = rect.height - (e.clientY - rect.top);
            // } else {
            //     y = 0;
            // }

        }

        if (!window.__mouseRightFileMange) window.__mouseRightFileMange = {};

        if (window.__mouseRightFileMange['level_' + childrenLevel]) {
            window.__mouseRightFileMange['level_' + childrenLevel]();
        }

        window.__mouseRightFileMange['level_' + childrenLevel] = handleClose;

        setAnchorEl({
            open: true,
            rel: e.currentTarget,
            top: y,
            left: x,
            translate: translate,
            // transform: 'translate(' + x + 'px, -' + y + 'px)'
        });

    }

    React.useEffect(() => {
        if (window.__mouseRightFileMange && window.__mouseRightFileMange['level_' + (childrenLevel + 1)]) {
            window.__mouseRightFileMange['level_' + (childrenLevel + 1)]();
            delete window.__mouseRightFileMange['level_' + (childrenLevel + 1)];
        }

        return () => {
            setAnchorEl({
                open: false,
                rel: null,
                translate: ''
            });
        }

    }, []);

    const handleClose = (e) => {
        if (e) {
            e.stopPropagation();
            e.preventDefault();
        }
        delete window.__mouseRightFileMange['level_' + childrenLevel];
        setAnchorEl(prev => ({
            ...prev,
            open: false,
            rel: null,
        }));
    };

    const transformOrigin = childrenLevel ? {
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

    return <React.Fragment>
        {
            React.createElement(component,
                {
                    onContextMenu: handelOnClickRight,
                    ...rest,
                    className: rest.className + ' ' + (anchorEl.rel ? 'menuMouseRight-selected' : ''),
                    onClick: (e) => {

                        if (window.__mouseRightFileMange && window.__mouseRightFileMange['level_' + (childrenLevel + 1)]) {
                            window.__mouseRightFileMange['level_' + (childrenLevel + 1)]();
                        }

                        if (childrenLevel) {
                            handelOnClickRight(e);
                        }

                        if (rest.onClick) {
                            rest.onClick(e);
                        }

                    }
                })
        }
        {
            Boolean(listMenu) &&
            (() => {
                if (anchorEl.open) {
                    return <ClickAwayListener disableReactTree={true} onClickAway={!childrenLevel ? handleClose : () => { }} >
                        <Popover
                            anchorEl={anchorEl.rel}
                            onClose={handleClose}
                            open={Boolean(anchorEl.rel)}
                            TransitionComponent={Collapse}
                            className={classes.menuPopover + ' ' + (!childrenLevel ? classes.notMenuChildren : '')}
                            {...transformOrigin}
                            style={{ '--translate': anchorEl.translate, backgroundColor: 'rgba(0,0,0,.3)', '--top': anchorEl.top, '--left': anchorEl.left, '--minWidth': minWidth ?? '320px' }}
                            onContextMenu={handleClose}
                        >
                            {
                                listMenu().map((menu, index) => (
                                    <React.Fragment key={index}>
                                        <List className={classes.menuFile} component="nav" aria-label="main mailbox folders">
                                            {
                                                Object.keys(menu).map(key => {

                                                    if (menu[key].hidden) {
                                                        return <React.Fragment key={key}></React.Fragment>
                                                    }

                                                    let actions = {};

                                                    if (menu[key].action) {
                                                        Object.keys(menu[key].action).forEach(event => {
                                                            actions[event] = (e) => {
                                                                menu[key].action[event](e, handleClose);
                                                            };
                                                        });
                                                    }


                                                    if (menu[key].children) {

                                                        // childrenMenu = <React.Fragment key={key}><ArrowRightIcon />{MenuMouseRight2.menu(menu[key].children)}</React.Fragment>;

                                                        return <MenuMouseRight
                                                            key={key}
                                                            childrenLevel={childrenLevel + 1}
                                                            minWidth={menu[key].minWidth ?? '320px'}
                                                            listMenu={() => menu[key].children}
                                                            component={ListItem}
                                                            {...actions}
                                                            button
                                                        >
                                                            {
                                                                Boolean(menu[key].icon) &&
                                                                <ListItemIcon>
                                                                    {menu[key].icon}
                                                                </ListItemIcon>
                                                            }
                                                            <ListItemText className={classes.itemText} primary={menu[key].title} />
                                                            <ArrowRightIcon />
                                                        </MenuMouseRight>
                                                    }

                                                    if (menu[key].component) {
                                                        return <React.Fragment key={key}>{(() => React.createElement(
                                                            menu[key].component,
                                                            {
                                                                handleClose: handleClose,
                                                                ...menu[key].componentProps
                                                            }
                                                        ))()}</React.Fragment>;
                                                    }

                                                    return <ListItem disabled={menu[key].disabled ? menu[key].disabled : false} key={key} button
                                                        {...actions}
                                                        onClick={(e) => {
                                                            if (window.__mouseRightFileMange['level_' + (childrenLevel + 1)]) {
                                                                window.__mouseRightFileMange['level_' + (childrenLevel + 1)]();
                                                            }
                                                            if (actions.onClick) {
                                                                actions.onClick(e);
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
            })()
        }
    </React.Fragment>
}

export default MenuMouseRight
