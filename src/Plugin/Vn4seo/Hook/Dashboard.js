import { Card, CardContent, Grid, makeStyles, Typography } from '@material-ui/core';
import HelpOutlineIcon from '@material-ui/icons/HelpOutline';
import React from 'react';
import {
    Link
} from "react-router-dom";
import { CircularCustom, CustomTooltip } from 'components';
import { useAjax } from 'utils/useAjax';
import DashboardAudit from '../compoments/DashboardAudit';
import { numberToThousoun } from '../helper';

const useStyles = makeStyles(() => ({
    overview: {
        '& .item': {
            position: 'relative',
            '& small': {
                fontSize: '85%',
            },
            '& h3': {
                overflow: 'hidden',
                textOverflow: 'ellipsis',
                marginBottom: 8,
                whiteSpace: 'nowrap',
                fontSize: 16,
                color: 'white',
                fontWeight: 400,
            },
            '& h2': {
                fontSize: 48,
                marginTop: 4,
                lineHeight: '38px',
                height: 38,
                color: 'white',
                fontWeight: 400,
            },
            '& .icon': {
                cursor: 'pointer',
                position: 'absolute',
                right: 12,
                bottom: 8,
                width: 18,
                color: 'white'
            },
            '& .link': {
                bottom: 'unset',
                top: 8,
            }
        },
    },
    itemContent: {
        height: '100%',
        minHeight: 222,
        textAlign: 'center',
        position: 'relative',
        display: 'flex',
        flexDirection: 'column',
        alignItems: 'center',
        justifyContent: 'center',
    }
}));

function Dashboard({ plugin }) {

    const classes = useStyles();

    const { ajax } = useAjax();

    let meta = {};

    if (plugin.meta) {
        meta = JSON.parse(plugin.meta);
    }

    if (!meta) {
        meta = {};
    }
    const [data, setData] = React.useState(false);
    const [audit, setAudit] = React.useState(false);
    const [website] = React.useState(meta.searchConsoleWebsites && meta.searchConsoleWebsites[0] ? meta.searchConsoleWebsites[0] : false);
    const [loadScript, setLoadScript] = React.useState(false);
    const [listDataType, setListDataType] = React.useState(
        [
            {
                id: 'clicks',
                title: 'Total clicks',
                value: '',
                active: true,
                color: '#3f51b5',
                description: 'is how many times a user clicked through to your site. How this is counted depends on the search result type.',
                linkHelper: 'https://support.google.com/webmasters/answer/7042828#click',
            },
            {
                id: 'impressions',
                title: 'Total impressions',
                value: '',
                active: true,
                color: '#5e35b1',
                description: 'is how many times a user saw a link to your site in search results. This is calculated differently for images and other search result types, depending on whether or not the result was scrolled into view.',
                linkHelper: 'https://support.google.com/webmasters/answer/7042828#impressions',
            },
            {
                id: 'ctr',
                title: 'Average CTR',
                value: '',
                active: false,
                color: '#00695f',
                description: 'is the percentage of impressions that resulted in a click.',
                linkHelper: 'https://support.google.com/google-ads/answer/2615875?hl=en',
            },
            {
                id: 'position',
                title: 'Average position',
                value: '',
                active: false,
                color: '#e8710a',
                description: 'is the average position of your site in search results, based on its highest position whenever it appeared in a search. Individual page position is available in the table below the chart. Position determination can be complicated by features such as carousels or Knowledge Panels.',
                linkHelper: 'https://support.google.com/webmasters/answer/7042828#position',
            },
        ]
    );


    const getFormatDateApi = (date) => {
        return date.getFullYear() + '-' + (('0' + (date.getMonth() + 1)).slice(-2)) + '-' + (('0' + date.getDate()).slice(-2));
    };

    React.useEffect(() => {

        if (website) {

            if (!document.getElementById('googleCharts')) {
                const script = document.createElement("script");
                script.id = 'googleCharts';
                script.src = "https://www.gstatic.com/charts/loader.js";
                script.async = true;

                script.onload = () => {
                    setLoadScript(true);
                };
                document.body.appendChild(script);
            } else {
                setLoadScript(true);
            }

            let d = new Date(), dayEnd = new Date();
            d.setDate(d.getDate() - 3);
            dayEnd.setDate(dayEnd.getDate() - 3);
            dayEnd.setMonth(d.getMonth() - 1);

            ajax({
                url: 'plugin/' + plugin.key_word + '/dashboard/reports',
                method: 'POST',
                data: {
                    step: 'getDataOverview',
                    website: website,
                    date: [
                        getFormatDateApi(d), getFormatDateApi(dayEnd)
                    ]
                },
                success: (result) => {
                    if (result.rows) {
                        setData(result);
                    }
                }
            });

            ajax({
                url: 'plugin/' + plugin.key_word + '/dashboard/audit',
                method: 'POST',
                data: {
                    url: website,
                    dashboard: true,
                },
                success: (result) => {
                    if (!result.error) {
                        setAudit(result);
                    }
                }
            });
        }

    }, []);

    React.useEffect(() => {

        if (website && data && loadScript) {
            window.google.charts.load('current', {
                'packages': ['corechart'], callback: function () {


                    let weekday = new Array(7);
                    weekday[0] = "Monday";
                    weekday[1] = "Tuesday";
                    weekday[2] = "Wednesday";
                    weekday[3] = "Thursday";
                    weekday[4] = "Friday";
                    weekday[5] = "Saturday";
                    weekday[6] = "Sunday";

                    let monthNames = ["January", "February", "March", "April", "May", "June",
                        "July", "August", "September", "October", "November", "December"
                    ];

                    let dataGoogle = {
                        clicks: [['Data', 'Clicks']],
                        impressions: [['Data', 'Impressions']],
                        ctr: [['Data', 'CTR']],
                        position: [['Data', 'Position']]
                    };

                    let maxPostion = 0;

                    let dataGoogleTotal = {
                        clicks: 0,
                        impressions: 0,
                        ctr: 0,
                        position: 0,
                    };

                    let dTemp;

                    if (data.rows) {
                        data.rows.forEach((item) => {

                            let d = new Date(item.keys[0]);

                            if (item.position > maxPostion) maxPostion = item.position;

                            dTemp = { v: d, f: weekday[d.getDay()] + ', ' + monthNames[d.getMonth()] + ' ' + d.getDate() };

                            dataGoogle.clicks.push([
                                dTemp,
                                item.clicks
                            ]);

                            dataGoogle.ctr.push([
                                dTemp,
                                { v: item.ctr * 100, f: ((item.ctr * 100).toFixed(1) * 1) + '%' }
                            ]);

                            dataGoogle.impressions.push([
                                dTemp,
                                item.impressions
                            ]);

                            dataGoogle.position.push([
                                dTemp,
                            ]);

                            dataGoogleTotal.clicks += item.clicks;
                            dataGoogleTotal.impressions += item.impressions;
                            dataGoogleTotal.ctr += item.ctr;
                            dataGoogleTotal.position += item.position;
                        });

                        data.rows.forEach((item, index) => {
                            dataGoogle.position[index + 1].push(
                                { v: (maxPostion - (item.position - maxPostion)), f: (item.position.toFixed(1) * 1).toString() }
                            );
                        });
                    }

                    let listDataTemp = JSON.parse(JSON.stringify(listDataType));

                    listDataTemp[0].value = numberToThousoun(dataGoogleTotal.clicks);
                    listDataTemp[1].value = numberToThousoun(dataGoogleTotal.impressions);

                    listDataTemp[2].value = (((dataGoogleTotal.ctr / data.rows?.length) * 100).toFixed(1) * 1).toString() + '%';
                    listDataTemp[3].value = (dataGoogleTotal.position / data.rows?.length).toFixed(1) * 1;

                    setListDataType(listDataTemp);

                    listDataType.forEach((item) => {

                        let options = {
                            title: '',
                            colors: ['rgb(5, 141, 199)'],
                            chartArea: { left: 0, right: 0 },
                            tooltip: { textStyle: { fontSize: 12 }, showColorCode: false },
                            backgroundColor: 'transparent',
                            focusTarget: 'category',
                            legend: 'none',
                            series: {
                                0: {
                                    areaOpacity: 0.54
                                }
                            },
                            showBarLabels: false,
                            hAxis: { ticks: [], textPosition: 'none', title: '', format: 'MMMM dd, yyyy', gridlines: { count: 0, color: 'transparent' } },
                            vAxis: {
                                baselineColor: item.color, gridlineColor: item.color, textPosition: 'out', minValue: 0, gridlines: { count: 0, color: 'transparent' }
                            },
                        };

                        let dataTable = window.google.visualization.arrayToDataTable(dataGoogle[item.id]);
                        let chart = new window.google.visualization.AreaChart(document.getElementById(item.id + '_chart'));
                        chart.draw(dataTable, options);

                    });
                }
            });
        }

    }, [data]);

    if (!website) {
        return null;
    }

    return (
        <>
            <Grid
                item
                lg={3}
                sm={6}
                xs={12}
            >
                <DashboardAudit audit={audit} keyAudit="performance" title="Performance" />
            </Grid>
            <Grid
                item
                lg={3}
                sm={6}
                xs={12}
            >
                <DashboardAudit audit={audit} keyAudit="seo" title="SEO" />
            </Grid>
            <Grid
                item
                lg={3}
                sm={6}
                xs={12}
            >
                <DashboardAudit audit={audit} keyAudit="best_practices" title="Best Practices" />
            </Grid>
            <Grid
                item
                lg={3}
                sm={6}
                xs={12}
            >
                <DashboardAudit audit={audit} keyAudit="accessibility" title="Accessibility" />
            </Grid>
            <Grid
                item
                lg={5}
                md={6}
                sm={6}
                xs={12}
            >

                <Grid
                    container
                    spacing={3}
                    className={classes.overview}
                    style={{ height: 'calc(100% + 24px)' }}
                >
                    {
                        listDataType.map((item, i) => (
                            <Grid
                                item
                                md={6}
                                xs={12}
                                key={i}
                                className='item'
                            >
                                <Card style={{ height: '100%' }} >
                                    <CardContent className={classes.itemContent} style={{ background: item.color }}>
                                        {
                                            data && loadScript
                                                ?
                                                <React.Fragment>
                                                    <Link to="/plugin/vn4seo/performance">
                                                        <Typography component="h3" variant="h3">
                                                            {item.title} <br />
                                                        </Typography>

                                                        <Typography component="h2" variant="h2" className={classes.title}>
                                                            {item.value}
                                                        </Typography>
                                                    </Link>
                                                    <div onClick={(e) => e.stopPropagation()}>
                                                        <CustomTooltip interactive={true} key={item.id} title={<><strong>{item.title}</strong> {item.description}<br /><a target="_blank" href={item.linkHelper}>LEARN MORE</a></>}   >
                                                            <HelpOutlineIcon className='icon' />
                                                        </CustomTooltip>
                                                    </div>
                                                    <div style={{ width: '100%', height: 100 }} id={item.id + '_chart'}>

                                                    </div>
                                                </React.Fragment>
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
        </>
    )
}

export default Dashboard
