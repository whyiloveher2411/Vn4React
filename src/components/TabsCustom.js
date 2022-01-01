import { withStyles, makeStyles, Collapse, Box } from '@material-ui/core';
import Tabs from '@material-ui/core/Tabs';
import Tab from '@material-ui/core/Tab';
import Button from '@material-ui/core/Button';
import React from 'react';
import { addClasses } from 'utils/dom';
import Divider from './DividerCustom';
import ExpandLess from '@material-ui/icons/ExpandLess';
import ExpandMore from '@material-ui/icons/ExpandMore';
import { fade } from '@material-ui/core/styles/colorManipulator';

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
    subTabsItem: {
        padding: '6px 16px 6px 40px',
        whiteSpace: 'initial',
        width: 'var(--tabWidth)',
        minWidth: 160,
        minHeight: 48,
        opacity: 0.7,
        textAlign: 'left',
        '&.active': {
            backgroundColor: fade(theme.palette.text.primary, 0.06)
        }
    },
    tabs: {
        background: theme.palette.body.background,
        display: 'flex',
        width: 'var(--tabWidth)',
        flexDirection: 'column',
        borderRight: `1px solid ${theme.palette.dividerDark}`,
        position: 'relative',
        '--color': theme.palette.primary.main,
        '&>.indicator': {
            position: 'absolute',
            right: 0,
            width: 2,
            height: 48,
            transition: 'all 300ms cubic-bezier(0.4, 0, 0.2, 1) 0ms',
            background: 'var(--color)',
        },
        '&>button': {
            width: 'var(--tabWidth)',
            minWidth: 160,
            minHeight: 48,
            opacity: 0.7,
            '&:not($hasSubTab).active': {
                opacity: 1,
                color: 'var(--color)',
            },
        },
        '& .MuiButton-label': {
            justifyContent: 'left',
            display: 'flex',
            alignItems: 'flex-start'
        }
    },
    tabsIcon: {
        '&>button': {
            minWidth: 0,
            minHeight: 0,
            height: 48,
        },
        '& .MuiButton-label': {
            justifyContent: 'center'
        }
    },
    hasSubTab: {

    },
    indicatorInline: {
        '& $tabsItem.active:not($hasSubTab):after, & $subTabsItem.active:after': {
            content: '""',
            position: 'absolute',
            right: 0,
            width: 2,
            height: 48,
            transition: 'all 300ms cubic-bezier(0.4, 0, 0.2, 1) 0ms',
            background: 'var(--color)',
        },
        '& $subTabsItem.active': {
            opacity: 1,
            color: 'var(--color)',
        },
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

function TabsCustom({ name, tabs, tabIcon, orientation = "horizontal", activeIndicator = true, tabWidth = 250, tabIndex, subTabIndex, propsContent, disableDense, ...props }) {

    const classes = useStyles();

    const [tabCurrent, setTableCurrent] = React.useState({
        [name]: tabIndex,
        [name + '_subTab']: subTabIndex,
    });

    const [openSubTab, setOpenSubTab] = React.useState({});

    const handleChangeTab = (i, subTabKey = null) => {
        if (tabs[i].subTab) {

            if (subTabKey !== null) {
                setTableCurrent({ ...tabCurrent, [name]: i, [name + '_subTab']: subTabKey });
                if (props.onChangeTab) {
                    props.onChangeTab(i, subTabKey);
                }
            } else {
                setOpenSubTab(prev => ({ ...prev, [i]: !prev[i] }));
            }

        } else {
            setTableCurrent({ ...tabCurrent, [name]: i, [name + '_subTab']: null });
            if (props.onChangeTab) {
                props.onChangeTab(i, subTabKey);
            }
        }
    };

    React.useEffect(() => {



    }, [tabCurrent])

    const getIndexFirstShow = (index) => {
        if (tabs[index].hidden) {
            return getIndexFirstShow(index + 1);
        }
        return index;
    }

    React.useEffect(() => {
        setTableCurrent({
            [name]: tabCurrent[name],
            [name + '_subTab']: tabCurrent[name + '_subTab']
        });

        setOpenSubTab(prev => {
            tabs.forEach((item, index) => {
                if (index === tabCurrent[name] && item.subTab) {
                    prev[index] = true;
                } else {
                    prev[index] = false;
                }
            });

            return { ...prev };
        });

    }, [name]);

    if (orientation === 'vertical') {
        return (
            <div className={classes.tabs2Root} style={{ '--tabWidth': (!tabIcon ? tabWidth : 58) + 'px' }}>
                <div className={addClasses({
                    [classes.tabs]: true,
                    [classes.tabsIcon]: tabIcon,
                    [classes.indicatorInline]: !activeIndicator
                })}>
                    {
                        activeIndicator &&
                        <span className='indicator' style={{ top: (tabCurrent[name] - tabs.filter((item, index) => index < tabCurrent[name] && item.hidden).length) * 48 }}></span>
                    }
                    {
                        tabs.map((tab, i) => (
                            !tab.hidden ?
                                <React.Fragment key={i}>
                                    <Button
                                        {...tab.buttonProps}
                                        onClick={() => handleChangeTab(i)}
                                        name={i}
                                        className={addClasses({
                                            [classes.tabsItem]: true,
                                            active: tabCurrent[name] === i,
                                            [classes.hasSubTab]: Boolean(tab.subTab)
                                        })}
                                        color="default"
                                        {...tab.restTitle}>
                                        <Box display="flex" width={1} justifyContent="space-between">
                                            {tab.title}
                                            {
                                                Boolean(tab.subTab) &&
                                                (
                                                    openSubTab[i] ? <ExpandLess /> : <ExpandMore />
                                                )
                                            }
                                        </Box>
                                    </Button>
                                    {
                                        Boolean(tab.subTab) &&
                                        <Collapse in={openSubTab[i]} timeout="auto" unmountOnExit>
                                            <Box display="flex" flexDirection="column">
                                                {
                                                    tab.subTab.map((subTabItem, indexSubTab) => (
                                                        <Button
                                                            {...subTabItem.buttonProps}
                                                            key={indexSubTab}
                                                            onClick={() => handleChangeTab(i, indexSubTab)}
                                                            name={i}
                                                            className={classes.subTabsItem + ((tabCurrent[name] === i && tabCurrent[name + '_subTab'] === indexSubTab) ? ' active' : '')}
                                                            color="default"
                                                            {...subTabItem.restTitle}>
                                                            {subTabItem.title}
                                                        </Button>
                                                    ))
                                                }
                                            </Box>
                                        </Collapse>
                                    }
                                </React.Fragment>
                                : <React.Fragment key={i}></React.Fragment>
                        ))
                    }
                </div>
                <div style={{ paddingLeft: 24, width: '100%' }}>
                    {
                        (() => {
                            if (tabs[tabCurrent[name]] && !tabs[tabCurrent[name]].hidden) {
                                if (tabCurrent[name + '_subTab'] !== null
                                    && tabs[tabCurrent[name]].subTab
                                    && tabs[tabCurrent[name]].subTab[tabCurrent[name + '_subTab']]
                                ) {
                                    return (tabs[tabCurrent[name]].subTab[tabCurrent[name + '_subTab']].content)(propsContent);
                                }
                                return (tabs[tabCurrent[name]].content)(propsContent);
                            } else {
                                setTableCurrent({ ...tabCurrent, [name]: getIndexFirstShow(0), [name + '_subTab']: null });
                            }
                        })()
                    }
                </div>
            </div >
        )
    }

    return (
        <div className={classes.scrollable}>
            <StyledTabs
                scrollButtons="auto"
                variant="scrollable"
                value={tabCurrent[name]}
                textColor="primary"
                className={addClasses({
                    [classes.dense]: !disableDense
                })}
                onChange={(e, v) => handleChangeTab(v)}
            >
                {tabs.map((tab, i) => (
                    <StyledTab
                        className={addClasses({
                            [classes.tabHorizontal]: true,
                            [classes.displayNone]: tab.hidden,
                        })}
                        key={i}
                        label={tab.title}
                        value={i}
                    />
                ))}
            </StyledTabs>
            <Divider color="dark" />
            <div className={classes.tabContent}>
                {
                    (() => {
                        if (tabs[tabCurrent[name]] && !tabs[tabCurrent[name]].hidden) {
                            return (tabs[tabCurrent[name]].content)(propsContent);
                        } else {
                            setTableCurrent({ ...tabCurrent, [name]: getIndexFirstShow(0), [name + '_subTab']: null });
                        }
                    })()
                }
            </div>
        </div>
    )
}

export default TabsCustom
