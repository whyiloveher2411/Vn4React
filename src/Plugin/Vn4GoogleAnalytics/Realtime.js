import { Card, CardContent, colors, Divider, Grid, makeStyles, Typography } from '@material-ui/core';
import RedirectWithMessage from 'components/RedirectWithMessage';
import React from 'react';
import { addScript } from 'utils/helper';
import { checkPermission } from 'utils/user';
import { Page } from '../../components';
import Browser from './compoments/Realtime/Browser';
import General from './compoments/Realtime/General';
import Location from './compoments/Realtime/Location';
import Map from './compoments/Realtime/Map';
import Pageviews from './compoments/Realtime/Pageviews';
import TopKeyword from './compoments/Realtime/TopKeyword';
import TopPages from './compoments/Realtime/TopPages';
import TrafficMedium from './compoments/Realtime/TrafficMedium';

const useStyles = makeStyles((theme) => ({
    headTop: {
        position: 'sticky',
        top: 0,
        background: '#f4f6f8',
        zIndex: 2,
        boxShadow: '2px 0px 0 #f4f6f8, -2px 0px 0 #f4f6f8'
    },
    title: {
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'space-between'
    },
    divider: {
        backgroundColor: colors.grey[300],
        margin: '24px 0',
    },
    titleSession: {
        height: 18,
        margin: '20px 0 20px 8px',
        fontSize: 16,
        fontWeight: 100
    },
    titleTop: {
        color: '#25405D',
        fontSize: '14px',
        marginBottom: 13,
        borderBottom: '2px solid #666',
        textAlign: 'left',
    },
    root: {
        '& .google-visualization-table-table td': {
            padding: '0.6em',
            fontSize: 12
        },
        '& thead tr, & .google-visualization-table-table th': {
            background: 'none',
            borderRight: 'none',
            borderLeft: 'none',
        },
        '& a': {
            color: 'inherit'
        },
        '& .not-data $titleTop': {
            borderBottom: '2px solid rgba(38, 50, 56, 0.11)',
        }
    }

}));

function Realtime({ ajaxPluginHandle, meta }) {

    const classes = useStyles();

    const [data, setData] = React.useState(false);
    const [loadScript, setLoadScript] = React.useState(false);
    const filter = React.useState(false);

    const permission = checkPermission('plugin_google_analytics_view_realtime');

    React.useEffect(() => {
        if (permission) {

            addScript("https://www.gstatic.com/charts/loader.js", 'googleCharts', () => {
                setLoadScript(true);
            });

            window.charts = {};

            return () => {
                clearTimeout(window.__GA_TIMEOUT_UPDATE_REALTIME);
                window.charts = null;
            }
        }

    }, []);

    React.useEffect(() => {
        callData();
    }, [filter[0]]);

    const callData = () => {
        if (permission && meta.complete_installation) {
            clearTimeout(window.__GA_TIMEOUT_UPDATE_REALTIME);

            ajaxPluginHandle({
                url: 'dashboard/realtime',
                notShowLoading: true,
                data: {
                    filter: filter[0],
                },
                success: (result) => {

                    if (result.total) {

                        setData(result);

                        window.__GA_TIMEOUT_UPDATE_REALTIME = setTimeout(() => {
                            callData();
                        }, 10000);

                    }
                }
            });
        }
    }

    const gridTemplate = [
        {
            grid: {
                md: 4, xs: 12
            },
            gridCompoment: [
                {
                    compoment: General
                },
                {
                    compoment: TopKeyword
                },
                {
                    compoment: TrafficMedium
                },
                {
                    compoment: Browser
                },
                {
                    compoment: Location
                },
            ]
        },
        {
            grid: {
                md: 8, xs: 12
            },
            gridCompoment: [
                {
                    compoment: Pageviews
                },
                {
                    compoment: TopPages
                },
                {
                    compoment: Map,
                    cardContent: {
                        style: { padding: 0 }
                    }
                },
            ]
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
        <Page width="xl" className={classes.main} title="Vn4 Google Analytics">
            <div className={classes.headTop}>
                <Grid
                    container
                    className={classes.grid}
                    justify="space-between"
                    spacing={3}>
                    <Grid item xs={12}>
                        <Typography component="h2" gutterBottom variant="overline">Vn4 Google Analytics</Typography>
                        <Typography component="h1" variant="h3" className={classes.title}>
                            Realtime
                        </Typography>
                    </Grid>
                </Grid>
                <Divider className={classes.divider} />
            </div>
            <div className={classes.root}>
                <Grid
                    container
                    className={classes.grid + ' ' + (!data ? 'not-data' : '')}
                    justify="space-between"
                    spacing={2}>

                    {
                        gridTemplate.map((item, index) => (
                            <Grid key={index} item {...item.grid} >
                                <Grid
                                    container
                                    className={classes.grid}
                                    justify="space-between"
                                    alignItems="center"
                                    spacing={2}>
                                    {
                                        item.gridCompoment.map((item2, index2) => (
                                            <Grid key={index2} item md={12} xs={12} >
                                                <Card>
                                                    <CardContent style={{ padding: 16 }} {...item2.cardContent}>
                                                        <item2.compoment classStyle={classes} filter={filter} google={window.google} data={data} />
                                                    </CardContent>
                                                </Card>
                                            </Grid>
                                        ))
                                    }
                                </Grid>
                            </Grid>
                        ))
                    }
                </Grid>
            </div>
        </Page>
    )
}

export default Realtime
