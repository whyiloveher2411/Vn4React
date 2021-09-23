import { Box, Card, CardContent, CardHeader, Grid, makeStyles, Table, TableBody, TableCell, TableContainer, TableHead, TablePagination, TableRow, Typography } from '@material-ui/core';
import { CommingSoon } from 'components';
import { scoreLabel } from 'plugins/Vn4seo/helper';
import React from 'react';
import { useSelector } from 'react-redux';
import { addScript } from 'utils/helper';
import { usePluginMeta } from 'utils/plugin';


const useStyles = makeStyles(theme => ({
    card: {
        height: '100%',
        '--color-fast': '#0cce6b',
        '--color-average': '#ffa400',
        '--color-slow': '#ff4e42',
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

function SEOPerformanceProductPage() {
    const classes = useStyles();

    const theme = useSelector(state => state.theme);

    const pluginMeta = usePluginMeta('vn4seo');


    const lighthouseData = [
        {
            title: 'Performance',
            mobile: 0.12,
            desktop: 0.45
        },
        {
            title: 'SEO',
            mobile: 0.55,
            desktop: 0.65
        },
        {
            title: 'Best Practices',
            mobile: 0.73,
            desktop: 0.90
        },
        {
            title: 'Accessibility',
            mobile: 0.73,
            desktop: 0.67
        },
    ];

    const webmasterToolData = [
        {
            title: 'Total clicks',
            value: '101.5K',
            color: 'rgb(63, 81, 181)',
        },
        {
            title: 'Total impressions',
            value: '1.15M',
            color: 'rgb(94, 53, 177)',
        },
        {
            title: 'Average CTR',
            value: '8.8%',
            color: 'rgb(0, 105, 95)',
        },
        {
            title: 'Average position',
            value: '19.5',
            color: 'rgb(232, 113, 10)',
        },
    ];



    const LighthouseValue = ({ scrore }) => {
        return <Typography
            gutterBottom
            component="p"
            variant="h1"
            className={classes.lighthouseValue}
            align="center"
            style={{
                '--color': 'var(--color-' + scoreLabel(scrore) + ')'
            }}
        >
            {parseInt(scrore * 100)}
        </Typography>
    };


    React.useEffect(() => {
        addScript("https://www.gstatic.com/charts/loader.js", 'googleCharts', () => {

            window.google.charts.load('current', { packages: ['corechart', 'line'] });
            window.google.charts.setOnLoadCallback(drawBasic);

            function drawBasic() {

                if (document.getElementById('chart_daily')) {

                    let data = new window.google.visualization.DataTable();
                    data.addColumn('number', 'X');
                    data.addColumn('number', 'Dogs');

                    data.addRows([
                        [0, 0], [1, 10], [2, 23], [3, 17], [4, 18], [5, 9],
                        [6, 11], [7, 27], [8, 33], [9, 40], [10, 32], [11, 35],
                        [12, 30], [13, 40], [14, 42], [15, 47], [16, 44], [17, 48],
                        [18, 52], [19, 54], [20, 42], [21, 55], [22, 56], [23, 57],
                        [24, 60], [25, 50], [26, 52], [27, 51], [28, 49], [29, 53],
                        [30, 55], [31, 60], [32, 61], [33, 59], [34, 62], [35, 65],
                        [36, 62], [37, 58], [38, 55], [39, 61], [40, 64], [41, 65],
                        [42, 63], [43, 66], [44, 67], [45, 69], [46, 69], [47, 70],
                        [48, 72], [49, 68], [50, 66], [51, 65], [52, 67], [53, 70],
                        [54, 71], [55, 72], [56, 73], [57, 75], [58, 70], [59, 68],
                        [60, 64], [61, 60], [62, 65], [63, 67], [64, 68], [65, 69],
                        [66, 70], [67, 72], [68, 75], [69, 80]
                    ]);

                    let options = {
                        backgroundColor: 'transparent',
                        legend: { textStyle: { color: theme.palette.text.secondary } },
                        chartArea: { left: 0, right: 0 },
                        hAxis: {
                            title: 'Time',
                            titleTextStyle: {
                                color: theme.palette.text.secondary
                            },
                            textStyle: {
                                color: theme.palette.text.secondary
                            },
                            baselineColor: 'none'
                        },
                        vAxis: {
                            titleTextStyle: {
                                color: theme.palette.text.secondary
                            },
                            textStyle: {
                                color: theme.palette.text.secondary
                            },
                            baselineColor: 'none'
                        }
                    };

                    let chart = new window.google.visualization.LineChart(document.getElementById('chart_daily'));

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
                md={8}
            >
                <Grid container spacing={3}>

                    {
                        lighthouseData.map((item, index) => (
                            <Grid
                                item
                                xs={12}
                                sm={4}
                                md={3}
                                key={index}
                            >
                                <Card className={classes.card}>
                                    <CardContent>
                                        <Typography
                                            gutterBottom
                                            variant="h5"
                                            className={classes.title}
                                        >
                                            {item.title}
                                        </Typography>

                                        <Box className={classes.boxValue} display="flex" justifyContent="space-between" alignItems="center" gridGap={8}>
                                            <div>
                                                <LighthouseValue scrore={item.mobile} />
                                                <Typography
                                                    gutterBottom
                                                    component="p"
                                                    variant="body2"
                                                    align="center"
                                                >
                                                    Mobile
                                                </Typography>
                                            </div><div>
                                                <LighthouseValue scrore={item.desktop} />
                                                <Typography
                                                    gutterBottom
                                                    component="p"
                                                    variant="body2"
                                                    align="center"
                                                >
                                                    Desktop
                                                </Typography>
                                            </div>
                                        </Box>
                                    </CardContent>
                                </Card>
                            </Grid>
                        ))
                    }
                    {
                        webmasterToolData.map((item, index) => (
                            <Grid
                                item
                                xs={12}
                                md={6}
                                key={index}
                            >
                                <Card style={{ backgroundColor: item.color }} className={classes.card}>
                                    <CardContent>
                                        <Typography
                                            gutterBottom
                                            variant="h5"
                                            className={classes.title + ' ' + classes.contrastText}
                                        >
                                            {item.title}
                                        </Typography>
                                        <Typography
                                            gutterBottom
                                            component="p"
                                            variant="h1"
                                            className={classes.value}
                                        >
                                            {item.value}
                                        </Typography>
                                    </CardContent>
                                </Card>
                            </Grid>
                        ))
                    }
                    <Grid
                        item
                        xs={12}
                        md={12}
                    >
                        <Card style={{ height: 255 }} className={classes.card}>
                            <CardContent>
                                <div id="chart_daily"></div>
                            </CardContent>
                        </Card>
                    </Grid>
                </Grid>
            </Grid>

            <Grid
                item
                xs={12}
                md={4}
            >
                <Card className={classes.card}>
                    <CardContent>
                        <Typography
                            gutterBottom
                            variant="h5"
                            className={classes.title}
                        >
                            Top Queries
                        </Typography>

                        <TableContainer className={' custom_scroll custom'} style={{ maxHeight: 650, overflowY: 'auto' }}>
                            <Table style={{ width: '100%' }} aria-label="table">
                                <TableHead>
                                    <TableRow>
                                        <TableCell style={{ backgroundColor: 'inherit' }}>
                                            Query
                                        </TableCell>
                                        <TableCell className={classes.tdPoint}>
                                            Clicks
                                        </TableCell>
                                    </TableRow>
                                </TableHead>
                                <TableBody>
                                    {
                                        [...Array(100)].map((row, index) => (
                                            <TableRow key={index} hover role="checkbox" tabIndex={-1}>
                                                <TableCell style={{ wordBreak: 'break-all' }}>
                                                    shinhan bank
                                                </TableCell>
                                                <TableCell className={classes.tdPoint}>
                                                    59,991
                                                </TableCell>
                                            </TableRow>
                                        ))
                                    }
                                </TableBody>
                            </Table>
                        </TableContainer>
                    </CardContent>
                </Card>
            </Grid>
        </Grid >
    )
}

export default SEOPerformanceProductPage
