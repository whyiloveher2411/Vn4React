import { Box, Card, CardContent, CardHeader, Grid, makeStyles, Table, TableBody, TableCell, TableContainer, TableHead, TablePagination, TableRow, Typography } from '@material-ui/core';
import { CommingSoon } from 'components';
import { scoreLabel } from 'Plugin/Vn4seo/helper';
import React from 'react';
import { useSelector } from 'react-redux';
import { addScript } from 'utils/helper';
import { usePluginMeta } from 'utils/plugin';
import General from './Reports/General';
import Demographics from './Reports/Demographics';
import Traffics from './Reports/Traffics';
import UserReturn from './Reports/UserReturn';

const useStyles = makeStyles(theme => ({
    card: {
        height: '100%',
        '--color-fast': '#0cce6b',
        '--color-average': '#ffa400',
        '--color-slow': '#ff4e42',
        overflow: 'initial',
        '& .MuiTypography-h1': {
            fontSize: 36
        },
        '& #chart_30 svg>g>g>g:nth-child(1) rect': {
            fill: 'transparent !important',
        },
        '& #chart_30 svg': {
            overflow: 'initial !important',
        }
    },
    disableColorGrid: {
        '& svg>g>g>g:nth-child(1) rect': {
            fill: theme.palette.divider + ' !important',
        },
    },
    title: {
        color: theme.palette.text.secondary,
        fontWeight: 'normal',
    },
    contrastText: {
        color: theme.palette.secondary.contrastText,
        opacity: .7
    },
    lighthouseValue: {
        color: 'var(--color)',
    },
    value: {
        color: theme.palette.primary.contrastText
    }
}));

function Reports() {
    const classes = useStyles();

    const theme = useSelector(state => state.theme);

    const pluginMeta = usePluginMeta('vn4seo');

    const [google, setGoogle] = React.useState(null);

    React.useEffect(() => {
        addScript("https://www.gstatic.com/charts/loader.js", 'googleCharts', () => {
            setGoogle(window.google);

            window.google.charts.load('current', { packages: ['corechart', 'line'] });
            window.google.charts.setOnLoadCallback(drawBasic);

            function drawBasic() {

                if (document.getElementById('chart_30')) {
                    var data = window.google.visualization.arrayToDataTable([
                        ['Time', 'Users'],
                        ['29 mins ago', 1],
                        ['28 mins ago', 2],
                        ['27 mins ago', 3],
                        ['26 mins ago', 4],
                        ['25 mins ago', 5],
                        ['24 mins ago', 1],
                        ['23 mins ago', 2],
                        ['22 mins ago', 3],
                        ['21 mins ago', 4],
                        ['20 mins ago', { v: 1, f: '0' }],
                        ['19 mins ago', 11],
                        ['18 mins ago', 12],
                        ['17 mins ago', 13],
                        ['16 mins ago', 14],
                        ['15 mins ago', 15],
                        ['14 mins ago', 8],
                        ['13 mins ago', 3],
                        ['12 mins ago', 1],
                        ['11 mins ago', 6],
                        ['10 mins ago', 8],
                        ['9 mins ago', 16],
                        ['8 mins ago', 11],
                        ['7 mins ago', 14],
                        ['6 mins ago', 9],
                        ['5 mins ago', 2],
                        ['4 mins ago', 5],
                        ['3 mins ago', 6],
                        ['2 mins ago', 12],
                        ['1 min ago', 18],
                    ]);


                    let options = {
                        title: "",
                        width: '100%',
                        height: '70',
                        tooltip: { isHtml: true, showColorCode: false },
                        bar: { groupWidth: '100%' },
                        vAxis: { textStyle: { maxAlternation: 4, fontSize: '11', color: theme.palette.text.secondary }, baseline: 0, minValue: 0, gridlines: { count: 5 } },
                        titleTextStyle: { color: 'transparent' },
                        backgroundColor: 'transparent',
                        chartArea: { left: 0, right: 0, top: 20, },
                        legend: { position: 'none' },
                        isStacked: false,
                        tooltip: { textStyle: { fontSize: 13 }, ignoreBounds: true },
                        animation: {
                            duration: 2500,
                            startup: true
                        }
                    };

                    // var options = {
                    //     title: "Density of Precious Metals, in g/cm^3",
                    //     width: 600,
                    //     height: 400,
                    //     bar: {groupWidth: '95%'},
                    //     legend: { position: 'none' },
                    //   };
                    //   var chart = new google.visualization.ColumnChart(document.getElementById('columnchart_plain'));
                    //   chart.draw(data, options);


                    let chart = new window.google.visualization.ColumnChart(document.getElementById('chart_30'));
                    chart.draw(data, options);
                }

                if (document.getElementById('chart_device')) {

                    let data = window.google.visualization.arrayToDataTable([
                        ['Device', 'Users'],
                        ['Mobile ', 10],
                        ['Desktop', 0],
                        ['Tablet', 21],
                    ]);

                    let options = {
                        title: '',
                        backgroundColor: 'transparent',
                        colors: ['#4285f4', '#45a5f5', '#93d5ed'],
                        pieHole: 0.7,
                        pieSliceBorderColor: 'transparent',
                        pieSliceText: "none",
                        chartArea: { height: 125 },
                        tooltip: { textStyle: { fontSize: 13 }, ignoreBounds: true },
                        legend: { position: 'bottom', textStyle: { color: theme.palette.text.primary, fontSize: 14 } },
                    };

                    let chart = new window.google.visualization.PieChart(document.getElementById('chart_device'));
                    chart.draw(data, options);

                }
            }
        });
    }, []);

    return (
        <Grid container spacing={3}>
            <Grid
                item
                xs={12}
                md={3}
            >
                <Card className={classes.card}>
                    <CardContent>
                        <Typography
                            gutterBottom
                            variant="h5"
                            className={classes.title}
                        >
                            Users in last 30 minutes
                        </Typography>
                        <Typography variant="h1" component="p">12</Typography>
                        <div id="chart_30" style={{ marginBottom: 5 }}></div>
                        <Typography
                            gutterBottom
                            variant="h5"
                            className={classes.title}
                        >
                            Device category in last 30 minutes
                        </Typography>
                        <div id="chart_device" style={{ marginBottom: 5 }}></div>
                    </CardContent>
                </Card>
            </Grid>
            <Grid
                item
                xs={12}
                md={3}
            >
                <Card className={classes.card}>
                    <CardContent>
                        <UserReturn google={google} />
                    </CardContent>
                </Card>
            </Grid>
            <Grid
                item
                xs={12}
                md={6}
            >
                <Card className={classes.card}>
                    <CardContent style={{ padding: 0 }}>
                        <General google={google} />
                    </CardContent>
                </Card>
            </Grid>
            <Grid
                item
                xs={12}
                md={6}
            >
                <Card className={classes.card + ' ' + classes.disableColorGrid}>
                    <CardContent>
                        <Typography
                            gutterBottom
                            variant="h5"
                            className={classes.title}
                        >
                            Demographics
                        </Typography>
                        <Demographics google={google} />
                    </CardContent>
                </Card>
            </Grid>

            <Grid
                item
                xs={12}
                md={6}
            >
                <Card className={classes.card}>
                    <CardContent style={{ padding: 0 }}>
                        <Traffics google={google} />
                    </CardContent>
                </Card>
            </Grid>
        </Grid >
    )
}

export default Reports
