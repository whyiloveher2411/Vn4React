import { Box, Card, CardContent, makeStyles, Typography } from '@material-ui/core';
import Collapse from '@material-ui/core/Collapse';
import { Button, CircularCustom, FieldForm, MaterialIcon, TabsCustom } from 'components';
import { PageHeaderSticky } from 'components/Page';
import RedirectWithMessage from 'components/RedirectWithMessage';
import React from 'react';
import { useDispatch } from 'react-redux';
import { Redirect, useHistory, useRouteMatch } from 'react-router-dom';
import { update } from 'reducers/settings';
import { __ } from 'utils/i18n';
import { useAjax } from 'utils/useAjax';
import { usePermission } from 'utils/user';

const useStyles = makeStyles((theme) => ({
    root: {
        flexGrow: 1,
        marginTop: theme.spacing(3),
        position: 'relative',
        minHeight: 250
    },
}));

const TabContent = ({ title, description, post, data, onReview, groupFields }) => {

    return (
        <>
            <Typography variant='h4' style={{ marginBottom: 8 }}>
                {title}
            </Typography>
            <Typography style={{ marginBottom: 24 }}>
                {description}
            </Typography>
            <Box display="flex" flexDirection="column" gridGap={24}>
                {
                    Array.isArray(groupFields) && groupFields.map((group, index) => (
                        group.template && group.template === 'BLANK' ?
                            <Box display="flex" key={index} flexDirection="column" gridGap={24}>
                                {
                                    Boolean(group.fields) && Object.keys(group.fields).map(keyField => (
                                        !group.fields[keyField].hidden ?
                                            <Collapse key={keyField} style={{ marginTop: -24 }} in={group.fields[keyField].active ? Boolean(post[group.fields[keyField].active]) : true}>
                                                <Box style={{ marginTop: 24 }} display="flex" flexDirection="column" gridGap={8}>
                                                    {
                                                        group.fields[keyField].view !== 'custom' ?
                                                            <FieldForm
                                                                compoment={group.fields[keyField].view}
                                                                config={group.fields[keyField]}
                                                                post={post}
                                                                name={keyField}
                                                                onReview={(value, key = keyField) => onReview(value, key)}
                                                            />
                                                            :
                                                            (() => {
                                                                // try {

                                                                let resolved = require(`./${group.fields[keyField].component}`).default;
                                                                return React.createElement(resolved, {
                                                                    config: group.fields[keyField],
                                                                    post: post,
                                                                    name: keyField,
                                                                    onReview: (value, key = keyField) => onReview(value, key)
                                                                });
                                                                // } catch (error) {

                                                                // }
                                                            })()
                                                    }
                                                </Box>
                                            </Collapse>
                                            :
                                            <React.Fragment key={keyField}></React.Fragment>
                                    ))
                                }
                            </Box>
                            :
                            <Card key={index} >
                                <CardContent>
                                    <Box display="flex" flexDirection="column" gridGap={24}>
                                        {
                                            Boolean(group.fields) && Object.keys(group.fields).map(keyField => (
                                                !group.fields[keyField].hidden ?
                                                    <Collapse key={keyField} style={{ marginTop: -24 }} in={group.fields[keyField].active ? Boolean(post[group.fields[keyField].active]) : true}>
                                                        <Box style={{ marginTop: 24 }} display="flex" flexDirection="column" gridGap={8}>
                                                            {
                                                                group.fields[keyField].view !== 'custom' ?
                                                                    <FieldForm
                                                                        compoment={group.fields[keyField].view}
                                                                        config={group.fields[keyField]}
                                                                        post={post}
                                                                        name={keyField}
                                                                        onReview={(value, key = keyField) => onReview(value, key)}
                                                                    />
                                                                    :
                                                                    (() => {
                                                                        // try {

                                                                        let resolved = require(`./${group.fields[keyField].component}`).default;
                                                                        return React.createElement(resolved, {
                                                                            config: group.fields[keyField],
                                                                            post: post,
                                                                            name: keyField,
                                                                            onReview: (value, key = keyField) => onReview(value, key)
                                                                        });
                                                                        // } catch (error) {

                                                                        // }
                                                                    })()
                                                            }
                                                        </Box>
                                                    </Collapse>
                                                    :
                                                    <React.Fragment key={keyField}></React.Fragment>
                                            ))
                                        }
                                    </Box>
                                </CardContent>
                            </Card>
                    ))
                }
            </Box>
        </>
    )
}

function Settings() {

    const match = useRouteMatch();
    const history = useHistory();

    const dispatch = useDispatch();

    const classes = useStyles();

    let [data, setData] = React.useState({});

    const permission = usePermission('settings_management').settings_management;

    const { tab, subtab1 } = match.params;

    const { ajax, Loading } = useAjax();

    const [tabs, setTabs] = React.useState([]);

    const handleValidateTabsFromApi = (dataFromApi) => {

        let result = [];

        Object.keys(dataFromApi.tabs).forEach(key => {

            let tabItem = {
                title: dataFromApi.tabs[key].title,
                buttonProps: {
                    startIcon: <MaterialIcon icon={dataFromApi.tabs[key].icon} />
                },
                value: key,
                content: () => (key === tab && !subtab1) ?
                    <TabContent
                        keyTab={key}
                        title={dataFromApi.tabs[key].title}
                        description={dataFromApi.tabs[key].description}
                        post={dataFromApi.row || {}}
                        data={dataFromApi}
                        onReview={onReview}
                        groupFields={dataFromApi.config}
                    />
                    : <></>
            };

            if (dataFromApi.tabs[key].subTab) {
                let subTab = [];

                Object.keys(dataFromApi.tabs[key].subTab).forEach(keySubTab => {
                    subTab.push({
                        title: dataFromApi.tabs[key].subTab[keySubTab].title,
                        buttonProps: {
                            startIcon: <MaterialIcon icon={dataFromApi.tabs[key].subTab[keySubTab].icon} />
                        },
                        value: keySubTab,
                        content: () => (key === tab && keySubTab === subtab1) ?
                            <TabContent
                                keyTab={key}
                                keySubTab={keySubTab}
                                title={dataFromApi.tabs[key].subTab[keySubTab].title}
                                description={dataFromApi.tabs[key].subTab[keySubTab].description}
                                post={dataFromApi.row || {}}
                                data={dataFromApi}
                                onReview={onReview}
                                groupFields={dataFromApi.config}
                            />
                            : <></>
                    });
                });

                tabItem.subTab = subTab;
            }

            result.push(tabItem);
        });

        setTabs(result);

    }

    React.useEffect(() => {
        if (permission) {
            ajax({
                url: 'settings/get',
                method: 'POST',
                data: {
                    group: tab,
                    subGroup: subtab1,
                },
                success: function (result) {
                    setData(result);
                }
            });
        }
    }, [tab, subtab1]);

    const onReview = (value, key) => {

        setData(prev => {

            if (typeof key === 'object' && key !== null) {
                prev.row = {
                    ...prev.row,
                    ...key
                };
            } else {
                prev.row = {
                    ...prev.row,
                    [key]: value,
                };
            }

            return { ...prev };
        });
    };

    React.useEffect(() => {
        if (data.tabs) {
            handleValidateTabsFromApi(data);
        }
    }, [data]);

    const handleTabsChange = (index, subTab = null) => {

        if (subTab !== null) {
            history.push('/settings/' + tabs[index].value + '/' + tabs[index].subTab[subTab].value);
        } else {
            history.push('/settings/' + tabs[index].value);
        }
    }

    const handleSubmit = () => {

        ajax({
            url: 'settings/post',
            method: 'POST',
            data: {
                settings: data.row,
                group: tab,
                subGroup: subtab1,
            },
            isGetData: false,
            success: function (result) {
                if (result.row) {
                    dispatch(update(result.row));
                }
            }
        });
    };

    if (!permission) {
        return <RedirectWithMessage />
    }

    if (tabs[0] === undefined) {
        return <CircularCustom />;
    }

    let tabContentIndex = tabs.findIndex(item => item.value === tab);
    // tabs.find(t => t.value === tab);

    if (!tab || tabContentIndex < 0) {
        return <Redirect to={'/settings/' + tabs[0].value} />;
    }

    if (subtab1) {

        if (tabs[tabContentIndex].subTab && !tabs[tabContentIndex].subTab?.find(t => t.value === subtab1)) {
            return <Redirect to={'/settings/' + tabs[tabContentIndex].value + '/' + tabs[tabContentIndex].subTab[0].value} />;
        }

        if (!tabs[tabContentIndex].subTab) {
            return <Redirect to={'/settings/' + tabs[tabContentIndex].value} />;
        }

    }

    return (
        <PageHeaderSticky
            className={classes.main}
            title={__("Settings")}
            header={
                <div>
                    <Typography component="h2" gutterBottom variant="overline">
                        {__("Settings")}
                    </Typography>
                    <Box display="flex" justifyContent="space-between">
                        <Typography component="h1" variant="h3">
                            {__("Change settings that affect the entire website")}
                        </Typography>
                        <Button
                            type="submit"
                            onClick={handleSubmit}
                            color="success"
                            variant="contained">
                            {__('Save Changes')}
                        </Button>
                    </Box>
                </div>
            }
        >
            <div className={classes.root}>
                <TabsCustom
                    name={'settings_page'}
                    orientation='vertical'
                    tabWidth={300}
                    tabIndex={tabContentIndex}
                    onChangeTab={handleTabsChange}
                    tabs={tabs}
                    subTabIndex={subtab1 ? tabs[tabContentIndex].subTab.findIndex(t => t.value === subtab1) : null}
                    activeIndicator={false}
                />
            </div>
            {Loading}
        </PageHeaderSticky>
    );
}

export default Settings
