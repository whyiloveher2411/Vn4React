import { Button, Card, CardActions, CardContent, colors, Divider, makeStyles, Tab, Tabs, Typography } from '@material-ui/core';
import { CircularCustom, Page } from 'components';
import RedirectWithMessage from 'components/RedirectWithMessage';
import React from 'react';
import { Redirect, useHistory, useRouteMatch } from 'react-router-dom';
import { useAjax } from 'utils/useAjax';
import { checkPermission } from 'utils/user';
import { AdminTemplate, General, License, Reading, Security } from './tabs';

const useStyles = makeStyles((theme) => ({
    root: {
        flexGrow: 1,
        marginTop: theme.spacing(3),
        position: 'relative',
        minHeight: 250
    },
    divider: {
        backgroundColor: colors.grey[300],
    },
    tabs: {
        position: 'sticky',
        top: 0,
        backgroundColor: '#f4f6f8',
        zIndex: 2
    },
    tabsItem: {
        whiteSpace: 'nowrap',
    },
    saveButton: {
        color: theme.palette.white,
        backgroundColor: colors.green[600],
        '&:hover': {
            backgroundColor: colors.green[900],
        },
    },
}));

function Settings(props) {

    const match = useRouteMatch();
    const history = useHistory();

    const classes = useStyles();

    let [data, setData] = React.useState({});

    const permission = checkPermission('settings_management');

    const { tab } = match.params;

    const { ajax, Loading } = useAjax();

    React.useEffect(() => {
        if (permission) {
            ajax({
                url: 'settings/get',
                method: 'POST',
                success: function (result) {
                    setData(result);
                }
            });
        }
    }, []);

    const tabs = [
        { value: 'general', label: 'General' },
        // { value: 'license', label: 'License' },
        { value: 'reading-settings', label: 'Reading Settings' },
        { value: 'admin-template', label: 'Admin Template' },
        { value: 'security', label: 'Security' },
    ];


    const onReview = (value, key) => {
        data.row[key] = value;
        console.log(data.row);
    };

    const handleTabsChange = (event, value) => {
        history.push(value)
    }

    const handleSubmit = () => {

        ajax({
            url: 'settings/post',
            method: 'POST',
            data: data.row,
            isGetData: false,
            success: function (result) {

            }
        });
    };

    if (!permission) {
        return <RedirectWithMessage />
    }

    if (!tab) {
        return <Redirect to="/settings/general" />;
    }

    if (!tabs.find(t => t.value === tab)) {
        return <Redirect to="/errors/error-404" />;
    }


    return (
        <Page className={classes.main} title="Settings">
            <div>
                <Typography component="h2" gutterBottom variant="overline">
                    Settings
                </Typography>
                <Typography component="h1" variant="h3">
                    Change settings for a specific site
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
                <Divider className={classes.divider} />
                {
                    data.row ?
                        <Card >
                            <CardContent>
                                {tab === 'general' && <General post={data.row || {}} data={data} onReview={onReview} />}
                                {/* {tab === 'license' && <License post={data.row || {}} data={data} onReview={onReview} />} */}
                                {tab === 'reading-settings' && <Reading post={data.row || {}} data={data} onReview={onReview} />}
                                {tab === 'admin-template' && <AdminTemplate post={data.row || {}} data={data} onReview={onReview} />}
                                {tab === 'security' && <Security post={data.row || {}} data={data} onReview={onReview} />}
                            </CardContent>
                            <Divider />
                            <CardActions>
                                <Button
                                    className={classes.saveButton}
                                    type="submit"
                                    onClick={handleSubmit}
                                    variant="contained">
                                    Save Changes
                            </Button>
                            </CardActions>
                        </Card>
                        : <CircularCustom />
                }
            </div>
            {Loading}
        </Page>
    );
}

export default Settings
