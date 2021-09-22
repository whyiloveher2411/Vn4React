import { Card, CardContent, colors, Divider, Grid, makeStyles, Typography } from '@material-ui/core';
import RedirectWithMessage from 'components/RedirectWithMessage';
import React from 'react';
import { addScript } from 'utils/helper';
import { checkPermission } from 'utils/user';
import { CircularCustom } from 'components';
import { PageHeaderSticky } from 'components/Page';
import ActiveUserRightNow from './compoments/Reports/ActiveUserRightNow';
import Country from './compoments/Reports/Country';
import Device from './compoments/Reports/Device';
import General from './compoments/Reports/General';
import PageVisit from './compoments/Reports/PageVisit';
import TimeActive from './compoments/Reports/TimeActive';
import Traffic from './compoments/Reports/Traffic';
import UserTime from './compoments/Reports/UserTime';
import UserReturn from './compoments/Reports/UserReturn';

const useStyles = makeStyles((theme) => ({
    title: {
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'space-between'
    },
    titleSession: {
        height: 18,
        marginBottom: 18,
        fontSize: 16,
        fontWeight: 100,
        [theme.breakpoints.down('sm')]: {
            height: 'auto',
        },
    },
    content: {
        position: 'relative',
    }
}));

function Settings({ meta, ajaxPluginHandle }) {

    const classes = useStyles();

    const [loadScript, setLoadScript] = React.useState(false);
    const [data, setData] = React.useState(false);
    const [data2, setData2] = React.useState(false);

    const permission = checkPermission('plugin_google_analytics_view_dashboard');

    React.useEffect(() => {

        if (permission && meta.complete_installation) {

            addScript("https://www.gstatic.com/charts/loader.js", 'googleCharts', () => {
                setLoadScript(true);
            });

            ajaxPluginHandle({
                url: 'dashboard/reports',
                notShowLoading: true,
                data: {
                    step: 'getData1'
                },
                success: (result) => {
                    if (result.success) {
                        setData(result);
                    }
                }
            });

            ajaxPluginHandle({
                url: 'dashboard/reports',
                notShowLoading: true,
                data: {
                    step: 'getData2'
                },
                success: (result2) => {
                    if (result2.success) {
                        setData2(result2);
                    }
                }
            });

            console.error = function () { };
        }
    }, []);

    const charts = [
        {
            title: 'Google Analytics Home',
            compoment: General,
            data: 'data1',
            grid: {
                md: 6,
                xs: 12
            },
            cardContent: {
                style: { padding: 0, height: 500 }
            }
        },
        {
            title: '',
            compoment: ActiveUserRightNow,
            data: 'data1',
            grid: {
                md: 3,
                xs: 12
            },
            cardContent: {
                style: { background: '#4285f4', height: 500 }
            }
        },
        {
            title: 'What are your top devices?',
            compoment: Device,
            data: 'data2',
            grid: {
                md: 3,
                xs: 12
            },
            cardContent: {}
        },
        {
            title: 'How do you acquire users?',
            compoment: Traffic,
            data: 'data2',
            grid: {
                md: 6,
                xs: 12
            },
            cardContent: {
                style: { padding: 0, height: 500 }
            }
        },
        {
            title: 'Where are your users?',
            compoment: Country,
            data: 'data1',
            grid: {
                md: 3,
                xs: 12
            },
            cardContent: {}
        },
        {
            title: 'When do your users visit?',
            compoment: TimeActive,
            data: 'data2',
            grid: {
                md: 3,
                xs: 12
            },
            cardContent: {}
        },
        {
            grid: {
                md: 9,
                xs: 12
            },
            gridCompoment: [
                {
                    title: 'What pages do your users visit?',
                    compoment: PageVisit,
                    data: 'data2',
                    grid: {
                        md: 6,
                        xs: 12
                    },
                    cardContent: {
                        style: { height: 400 }
                    }
                },
                {
                    title: 'How are your active users trending over time?',
                    compoment: UserTime,
                    data: 'data2',
                    grid: {
                        md: 6,
                        xs: 12
                    },
                    cardContent: {
                        style: { height: 400 }
                    }
                },
            ]
        },
        {
            title: '',
            compoment: UserReturn,
            data: 'data1',
            grid: {
                md: 3,
                xs: 12
            },
            cardContent: {
                style: { height: 400 }
            }
        },
    ];

    if (!meta.complete_installation) {
        return <RedirectWithMessage
            message="Please install google analytics before using this feature!"
            to="/plugin/vn4-google-analytics/settings"
            variant="warning" />
    }

    if (!permission) {
        return <RedirectWithMessage />
    }


    return (
        <PageHeaderSticky
            width={1345}
            className={classes.main}
            title="Vn4 Google Analytics"
            header={
                <Grid
                    container
                    className={classes.grid}
                    justify="space-between"
                    alignItems="center"
                    spacing={3}>
                    <Grid item xs={12}>
                        <Typography component="h2" gutterBottom variant="overline">Vn4 Google Analytics</Typography>
                        <Typography component="h1" variant="h3" className={classes.title}>
                            Reports
                        </Typography>
                    </Grid>
                </Grid>
            }
        >
            <div style={{ maxWidth: 1345, margin: '0 auto' }}>
                <Grid
                    container
                    className={classes.grid}
                    justify="space-between"
                    spacing={2}>

                    {
                        charts.map((item, i) => (
                            item.gridCompoment ?
                                <Grid key={i} item {...item.grid}>
                                    <Grid
                                        container
                                        className={classes.grid}
                                        justify="space-between"
                                        alignItems="center"
                                        spacing={2}>
                                        {
                                            item.gridCompoment.map((item2, i2) => (
                                                <Grid key={i2} item {...item2.grid}>
                                                    <Typography className={classes.titleSession} component="h3" gutterBottom variant="body1">{item2.title}</Typography>
                                                    <Card>
                                                        <CardContent className={classes.content} style={{ height: 500 }} {...item2.cardContent}>
                                                            {
                                                                data && loadScript ?
                                                                    item2.data === 'data2' && !data2 ?
                                                                        <CircularCustom />
                                                                        :
                                                                        <item2.compoment dataGA2={data2} dataGA={data} google={window.google} />
                                                                    :
                                                                    <CircularCustom />
                                                            }
                                                        </CardContent>
                                                    </Card>
                                                </Grid>
                                            ))
                                        }
                                    </Grid>
                                </Grid>
                                :
                                <Grid key={i} item {...item.grid}>
                                    <Typography className={classes.titleSession} component="h3" gutterBottom variant="body1">{item.title}</Typography>
                                    <Card>
                                        <CardContent style={{ height: 500 }} className={classes.content} {...item.cardContent}>
                                            {
                                                data && loadScript ?
                                                    item.data === 'data2' && !data2 ?
                                                        <CircularCustom />
                                                        :
                                                        <item.compoment dataGA2={data2} dataGA={data} google={window.google} />
                                                    :
                                                    <CircularCustom />
                                            }
                                        </CardContent>
                                    </Card>
                                </Grid>
                        ))
                    }
                </Grid>
            </div>
        </PageHeaderSticky>
    );
}

export default Settings
