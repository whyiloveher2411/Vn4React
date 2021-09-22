import { Button, makeStyles, Tab, Tabs, withStyles } from '@material-ui/core';
import React from 'react';
import Divider from './DividerCustom';

const StyledTabs = withStyles({
    indicator: {
        display: 'flex',
        justifyContent: 'center',
        backgroundColor: 'transparent',
        '& > span': {
            width: '100%',
            backgroundColor: 'var(--color)',
        },
    },
})((props) => <Tabs {...props} TabIndicatorProps={{ children: <span /> }} />);

const StyledTab = withStyles((theme) => ({
    root: {
        textTransform: 'none',
        fontWeight: theme.typography.fontWeightRegular,
        fontSize: theme.typography.pxToRem(15),
        marginRight: theme.spacing(1),
        '&:focus': {
            opacity: 1,
        },
    },
}))((props) => <Tab disableRipple {...props} />);



const useStyles = makeStyles((theme) => ({
    root: {
        '& .tab-content': {
            marginTop: 16
        }
    },
    tabContent: {
        marginTop: 16
    },
    tabs2Root: {
        flexGrow: 1,
        backgroundColor: theme.palette.background.paper,
        display: 'flex',
        minHeight: 224,
    },
    displayNone: {
        display: 'none'
    },
    tabs1: {
        position: 'sticky',
        top: 0,
        zIndex: 2,
        '& .Mui-selected': {
            color: 'var(--color)',
        },
        '& .MuiTabs-indicator': {
            left: 'var(--left) !important',
            transition: 'all 300ms cubic-bezier(0.4, 0, 0.2, 1) 0ms',
        }
    },
    tabsItem: {
        padding: '6px 16px',
        whiteSpace: 'nowrap',
    },
    tabs: {
        background: theme.palette.body.background,
        display: 'flex',
        flexDirection: 'column',
        borderRight: `1px solid ${theme.palette.divider}`,
        position: 'relative',
        '--color': theme.palette.primary.main,
        '&>.indicator': {
            position: 'absolute',
            right: 0,
            width: 2,
            height: 48,
            transition: 'all 300ms cubic-bezier(0.4, 0, 0.2, 1) 0ms',
        },
        '&>button': {
            width: '100%',
            minWidth: 160,
            minHeight: 48,
            opacity: 0.7,
            '&.active': {
                opacity: 1,
                color: 'var(--color)',
            },
        },
        '& .MuiButton-label': {
            justifyContent: 'left'
        }
    },
    tabsIcon: {
        '&>button': {
            minWidth: 0,
            minHeight: 0,
            width: 48,
            height: 48,
        },
        '& .MuiButton-label': {
            justifyContent: 'center'
        }
    },
    tabHorizontal: {
        textTransform: 'unset',
        width: 'auto',
        minWidth: 'auto',
        paddingLeft: 0,
        paddingRight: 0,
        margin: '0 16px',
    },
    dense: {
        '--color': theme.palette.primary.main,
        '& $tabHorizontal:first-child': {
            marginLeft: 0
        }
    },
    scrollable: {
        '& .MuiTabScrollButton-root.Mui-disabled': {
            opacity: .2,
        }
    }

}));

function TabsCustom({ name, tabs, tabIcon, orientation = "horizontal", tabIndex, propsContent, disableDense, ...props }) {

    const classes = useStyles();

    const [tabCurrent, setTableCurrent] = React.useState({
        [name]: tabIndex
    });

    const handleChangeTab = (i) => {
        setTableCurrent({ ...tabCurrent, [name]: i });
        if (props.onChangeTab) {
            props.onChangeTab(i);
        }
    };

    const getIndexFirstShow = (index) => {
        if (tabs[index].hidden) {
            return getIndexFirstShow(index + 1);
        }
        return index;
    }

    if (orientation === 'vertical') {
        return (
            <div className={classes.tabs2Root}>
                <div className={classes.tabs + ' ' + (tabIcon ? classes.tabsIcon : '')}>
                    <span className='indicator' style={{ top: (tabCurrent[name] - tabs.filter((item, index) => index < tabCurrent[name] && item.hidden).length) * 48 }}></span>
                    {
                        tabs.map((tab, i) => (
                            !tab.hidden ?
                                <Button key={i} onClick={() => handleChangeTab(i)} name={i} className={classes.tabsItem + (tabCurrent[name] === i ? ' active' : '')} color="default" {...tab.restTitle}>{tab.title}</Button>
                                : <React.Fragment key={i}></React.Fragment>
                        ))
                    }
                </div>
                <div style={{ paddingLeft: 24, width: '100%' }}>
                    {
                        (() => {
                            if (tabs[tabCurrent[name]] && !tabs[tabCurrent[name]].hidden) {
                                return (tabs[tabCurrent[name]].content)(propsContent);
                            } else {
                                setTableCurrent({ ...tabCurrent, [name]: getIndexFirstShow(0) });
                            }
                        })()
                    }
                </div>
            </div>
        )
    }

    return (
        <div className={classes.scrollable}>
            <StyledTabs
                scrollButtons="auto"
                variant="scrollable"
                value={tabCurrent[name]}
                textColor="primary"
                className={disableDense ? '' : classes.dense}
                onChange={(e, v) => handleChangeTab(v)}
            >
                {tabs.map((tab, i) => (
                    <StyledTab className={classes.tabHorizontal + ' ' + (tab.hidden ? classes.displayNone : '')} key={i} label={tab.title} value={i} />
                ))}
            </StyledTabs>
            <Divider color="dark" />
            <div className={classes.tabContent}>
                {
                    (() => {
                        if (tabs[tabCurrent[name]] && !tabs[tabCurrent[name]].hidden) {
                            return (tabs[tabCurrent[name]].content)(propsContent);
                        } else {
                            setTableCurrent({ ...tabCurrent, [name]: getIndexFirstShow(0) });
                        }
                    })()

                }
            </div>
        </div>
    )

    return (

        <div className={classes.root}>

            <Tabs
                className={classes.tabs1 + ' ' + (tabIcon ? classes.tabsIcon : '')}
                onChange={(e, v) => handleChangeTab(v)}
                scrollButtons="auto"
                value={tabCurrent[name]}
                indicatorColor="primary"
                textColor="primary"
                style={{
                    '--left': (tabCurrent[name] - tabs.filter((item, index) => index < tabCurrent[name] && item.hidden).length) * 160 + 'px',
                    '--color': (tabs[tabCurrent[name]] && tabs[tabCurrent[name]].color) ? tabs[tabCurrent[name]].color : '#3f51b5'
                }}
                variant="scrollable">
                {tabs.map((tab, i) => (
                    <Tab className={classes.tabHorizontal + ' ' + (tab.hidden ? classes.displayNone : '')} key={i} label={tab.title} value={i} />
                ))}
            </Tabs>
            <Divider className={classes.divider} />
            <div className="tab-content">
                {
                    (() => {
                        if (tabs[tabCurrent[name]] && !tabs[tabCurrent[name]].hidden) {
                            return (tabs[tabCurrent[name]].content)(propsContent);
                        } else {
                            setTableCurrent({ ...tabCurrent, [name]: getIndexFirstShow(0) });
                        }
                    })()

                }
            </div>
        </div >
    )


}

export default TabsCustom
