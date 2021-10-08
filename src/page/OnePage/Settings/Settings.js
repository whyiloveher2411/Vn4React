import { Card, CardActions, CardContent, makeStyles, Tab, Tabs, Typography } from '@material-ui/core';
import { Button, CircularCustom, Page, Divider } from 'components';
import RedirectWithMessage from 'components/RedirectWithMessage';
import React from 'react';
import { Redirect, useHistory, useRouteMatch } from 'react-router-dom';
import { useAjax } from 'utils/useAjax';
import { checkPermission } from 'utils/user';
import { __ } from 'utils/i18n';
import { AdminTemplate, General, Reading, Security } from './tabs';
import { useDispatch } from 'react-redux';

const useStyles = makeStyles((theme) => ({
    root: {
        flexGrow: 1,
        marginTop: theme.spacing(3),
        position: 'relative',
        minHeight: 250
    },
    tabs: {
        position: 'sticky',
        top: 0,
        backgroundColor: theme.palette.body.background,
        zIndex: 2
    },
}));

function Settings() {

    const match = useRouteMatch();
    const history = useHistory();

    const dispatch = useDispatch();

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
        { value: 'general', label: __('General') },
        // { value: 'license', label: 'License' },
        { value: 'reading-settings', label: __('Reading Settings') },
        { value: 'admin-template', label: __('Admin Template') },
        { value: 'security', label: __('Security') },
    ];

    const onReview = (value, key) => {
        setData(prev => ({
            ...prev,
            row: {
                ...prev.row,
                [key]: value,
            }
        }))
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
                if (result.settings) {
                    dispatch({
                        type: 'SETTINGS_UPDATE',
                        payload: { ...result.settings }
                    });
                }
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
        <Page className={classes.main} title={__("Settings")}>
            <div>
                <Typography component="h2" gutterBottom variant="overline">
                    {__("Settings")}
                </Typography>
                <Typography component="h1" variant="h3">
                    {__("Change settings that affect the entire website")}
                </Typography>
            </div>
            <div className={classes.root}>
                <div className={classes.tabs}>
                    <Tabs
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
                </div>
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
                                    type="submit"
                                    onClick={handleSubmit}
                                    color="success"
                                    variant="contained">
                                    {__('Save Changes')}
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
