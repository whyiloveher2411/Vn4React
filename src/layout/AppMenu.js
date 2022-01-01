import { Button, ClickAwayListener, List, makeStyles, Tooltip, Typography } from '@material-ui/core';
import { Hook, MaterialIcon } from 'components';
import React from 'react';
import { useSelector } from 'react-redux';
import { matchPath } from 'react-router-dom';
import useRouter from '../utils/useRouter';
import NavigationListItem from './NavigationListItem';

const useStyles = makeStyles((theme) => ({
    root: {
        position: 'relative',
    },
    menuItem1: {
        display: 'flex',
        textTransform: 'inherit',
        padding: '12px',
        fontSize: 15,
        minWidth: 'auto',
        textAlign: 'left',
        borderBottom: '1px solid ' + theme.palette.dividerDark,
        borderRadius: 0,
    },
    nav: {
        minWidth: 48,
        display: 'flex', flexDirection: 'column', justifyContent: 'space-between',
        height: 'calc( 100vh - 66px )',
        maxHeight: 'calc( 100vh - 64px )',
        flex: '0 0 auto',
        zIndex: 3,
        overflowY: 'auto',
        backgroundColor: theme.palette.menu.background,
        borderRight: '1px solid ' + theme.palette.dividerDark,
    },
    subMenu: {
        height: '100vh',
        minWidth: '248px',
        position: 'absolute',
        top: '0',
        background: theme.palette.menu.background,
        right: '-1px',
        transform: 'translateX(100%)',
        zIndex: '98',
        marginLeft: '1px',
        borderRight: '1px solid ' + theme.palette.dividerDark,
        height: 'calc( 100vh - 66px )',
        maxHeight: 'calc( 100vh - 64px )',
        overflowY: 'auto',
    },
    menuSubTitle: {
        padding: '8px 16px 0 16px',
        fontSize: 17,
    },
}));


const NavigationList = props => {
    const { pages, ...rest } = props;

    return (
        <List>
            {pages.reduce(
                (items, page) => reduceChildRoutes({ items, page, ...rest }),
                []
            )}
        </List>
    );
};


const reduceChildRoutes = props => {
    const { router, items, page, depth } = props;

    if (page.children) {
        const open = matchPath(router.location.pathname, {
            path: page.href,
            exact: false
        });

        items.push(
            <NavigationListItem
                depth={depth}
                icon={page.icon}
                key={page.title}
                label={page.label}
                open={Boolean(open)}
                title={page.title}
                svgIcon={page.svgIcon ?? null}
            >
                <NavigationList
                    depth={depth + 1}
                    pages={page.children}
                    router={router}
                />
            </NavigationListItem>
        );
    } else {
        items.push(
            <NavigationListItem
                depth={depth}
                href={page.href}
                icon={page.icon}
                key={page.title}
                label={page.label}
                title={page.title}
                svgIcon={page.svgIcon ?? null}
            />
        );
    }

    return items;
};

const AppMenu = () => {

    const classes = useStyles();

    const menuItems = useSelector(state => state.sidebar);

    const [subMenuContent, setSubMenuContent] = React.useState(false);

    const router = useRouter();

    const handleOnClickMenu1 = (menu, key) => {

        if (subMenuContent.key === key) {
            setSubMenuContent(false);
        } else {
            setSubMenuContent({ ...menu, key: key });
        }
    }

    return (
        <ClickAwayListener disableReactTree={true} onClickAway={() => { if (subMenuContent !== false) setSubMenuContent(false); }} >
            <div className={classes.root}>
                <nav className={classes.nav + ' custom_scroll custom'} >
                    {
                        (() => {

                            let menuBottom = { management: true, support: true };

                            let menuTop = menuItems !== null && Object.keys(menuItems).filter(key => !menuBottom[key]).map((key) => (
                                <Tooltip key={key} title={menuItems[key].title} arrow placement="right" >
                                    <Button onClick={() => handleOnClickMenu1(menuItems[key], key)} className={classes.menuItem1}>
                                        <MaterialIcon icon={menuItems[key].icon} />
                                    </Button>
                                </Tooltip>
                            ));

                            menuBottom = menuItems !== null && menuItems.management && menuItems.support && ['management', 'support'].map((key) => (
                                <Tooltip key={key} title={menuItems[key].title} arrow placement="right" >
                                    <Button onClick={() => handleOnClickMenu1(menuItems[key], key)} className={classes.menuItem1}>
                                        <MaterialIcon icon={menuItems[key].icon} />
                                    </Button>
                                </Tooltip>
                            ));

                            return <><div>{menuTop}</div><div style={{ borderTop: '1px solid rgba(0,0,0,0.12)' }}>{menuBottom}</div></>
                        })()
                    }
                </nav>
                {
                    subMenuContent !== false &&
                    <div className={classes.subMenu + ' custom_scroll'}>
                        <Typography className={classes.menuSubTitle} variant="h4">{subMenuContent.title}</Typography>
                        {
                            subMenuContent.component ?
                                <Hook hook={subMenuContent.component} data={subMenuContent} />
                                :
                                <NavigationList
                                    depth={0}
                                    pages={subMenuContent.pages}
                                    router={router}
                                />
                        }
                    </div>
                }
            </div>
        </ClickAwayListener>
    )
}


export default AppMenu
