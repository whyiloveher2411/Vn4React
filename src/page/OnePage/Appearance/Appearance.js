import { makeStyles, Tab, Tabs, Typography } from '@material-ui/core';
import { Divider, Page } from 'components';
import React from 'react';
import { Redirect, useHistory, useRouteMatch } from 'react-router-dom';
import Menu from './components/Menu';
import Theme from './components/Theme';
import ThemeOptions from './components/ThemeOptions';
import Widget from './components/Widget';

const useStyles = makeStyles((theme) => ({
    root: {
        flexGrow: 1,
        marginTop: theme.spacing(3),
    },
    tabs: {
        position: 'sticky',
        top: 0,
        backgroundColor: theme.palette.body.background,
        zIndex: 2
    },
}));

function Appearance() {

    const match = useRouteMatch();
    const history = useHistory();

    const classes = useStyles();

    const { tab } = match.params

    const tabs = [
        { value: 'theme', label: 'Theme', component: <Theme key="theme" /> },
        { value: 'menu', label: 'Menu', component: <Menu key="menu" /> },
        { value: 'widget', label: 'Widget', component: <Widget key="widget" /> },
        { value: 'theme-options', label: 'Theme Options', component: <ThemeOptions key="theme-options" history={history} /> },
    ];

    const handleTabsChange = (event, value) => {
        history.push(value)
    }

    if (!tab) {
        return <Redirect to="/appearance/theme" />;
    }

    if (!tabs.find(t => t.value === tab)) {
        return <Redirect to="/errors/error-404" />;
    }

    return (
        <Page className={classes.main} title="Appearance">
            <div>
                <Typography component="h2" gutterBottom variant="overline">
                    Management
                </Typography>
                <Typography component="h1" variant="h3">
                    Appearance
                </Typography>
            </div>
            <div className={classes.root}>
                <Tabs
                    className={classes.tabs}
                    onChange={handleTabsChange}
                    scrollButtons="auto"
                    value={tab}
                    indicatorColor="primary"
                    textColor="primary"
                    variant="scrollable">
                    {tabs.map((tab) => (
                        <Tab key={tab.value} label={tab.label} value={tab.value} />
                    ))}
                </Tabs>
                <Divider color="dark" />
                {tabs.map((t, i) => (
                    tab === t.value ?
                        t.component
                        : <React.Fragment key={i}></React.Fragment>
                ))}
            </div>
        </Page>
    );
}

export default Appearance
