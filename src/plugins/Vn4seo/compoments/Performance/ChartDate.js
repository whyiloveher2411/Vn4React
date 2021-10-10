import { Card, CardContent, makeStyles, Typography } from '@material-ui/core';
import HelpOutlineIcon from '@material-ui/icons/HelpOutline';
import React from 'react';
import { addScript } from 'utils/helper';
import { CircularCustom, CustomTooltip } from 'components';
import { useSelector } from 'react-redux';


const useStyles = makeStyles((theme) => ({
    root: {
        marginBottom: 16,
        '& .google-visualization-tooltip': {
            whiteSpace: 'nowrap',
            zIndex: 1,
        },
        '& .google-visualization-tooltip-item': {
            display: 'flex',
            justifyContent: 'space-between',
            position: 'relative',
            paddingLeft: 40,
            '& span': {
                color: 'rgba(0,0,0,0.7) !important',
            }
        },
        '& .google-visualization-tooltip-item span:nth-child(3)': {
            paddingLeft: 16
        },
        '& .google-visualization-tooltip-square': {
            position: 'absolute',
            width: '12px',
            left: 16,
            top: 3,
            borderRadius: '20px',
        }
    },
    overview: {
        display: 'flex',
        '& .item': {
            width: 180,
            padding: 24,
            cursor: 'pointer',
            border: '1px solid rgba(0,0,0,0.12)',
            borderTop: 'none',
            margin: '0 -1px',
            position: 'relative',
            '&:not(.active)': {
                background: 'white !important',
                '& h3,& h2': {
                    color: 'rgba(0,0,0,0.54)',
                },
            },
            '& h3': {
                flex: '1 1 0',
                overflow: 'hidden',
                textOverflow: 'ellipsis',
                whiteSpace: 'nowrap',
                fontSize: 14,
                color: 'white',
                fontWeight: 400,
            },
            '& h2': {
                fontSize: 32,
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
                width: 18
            }
        }
    }
}));

const numberToThousoun = (labelValue) => {

    // Nine Zeroes for Billions
    return Math.abs(Number(labelValue)) >= 1.0e+9

        ? ((Math.abs(Number(labelValue)) / 1.0e+9).toFixed(2) * 1) + "B"
        // Six Zeroes for Millions 
        : Math.abs(Number(labelValue)) >= 1.0e+6

            ? ((Math.abs(Number(labelValue)) / 1.0e+6).toFixed(2) * 1) + "M"
            // Three Zeroes for Thousands
            : Math.abs(Number(labelValue)) >= 1.0e+3

                ? ((Math.abs(Number(labelValue)) / 1.0e+3).toFixed(1) * 1) + "K"

                : Math.abs(Number(labelValue));

}

function ChartDate({ ajaxPluginHandle, website, date, labelDateFilter }) {
    const classes = useStyles();

    const theme = useSelector(s => s.theme);
    const [loadScript, setLoadScript] = React.useState(false);
    const [dataAjax, setDataAjax] = React.useState(false);

    React.useEffect(() => {

        addScript("https://www.gstatic.com/charts/loader.js", 'googleCharts', () => {
            setLoadScript(true);
        });

        ajaxPluginHandle({
            url: 'dashboard/reports',
            notShowLoading: true,
            data: {
                step: 'getDataOverview',
                website: website,
                date: labelDateFilter[date.index].date(),
            },
            success: (result) => {
                if (!result.error) {
                    setDataAjax(result.rows);
                }
            }
        });


    }, [website, date]);

    const [listDataType, setListDataType] = React.useState(
        [
            {
                id: 'click',
                title: 'Total clicks',
                value: '',
                active: true,
                color: '#4285f4',
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
                color: '#00897b',
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



    const loadChartOverview = () => {
        window.google.charts.load('current', {
            'packages': ['corechart', 'geochart'], callback: function () {

                let dataUsers = [], ticks = [];

                let general = {
                    max: {
                        clicks: 0,
                        impressions: 0,
                        ctr: 0,
                        position: 0,
                    },
                    total: {
                        clicks: 0,
                        impressions: 0,
                        ctr: 0,
                        position: 0,
                    },
                    avg: {
                        clicks: 0,
                        impressions: 0,
                        ctr: 0,
                        position: 0,
                    }
                };

                dataAjax.forEach(item => {

                    if (item.clicks > general.max.clicks) general.max.clicks = item.clicks;
                    if (item.impressions > general.max.impressions) general.max.impressions = item.impressions;
                    if (item.ctr > general.max.ctr) general.max.ctr = item.ctr;
                    if (item.position > general.max.position) general.max.position = item.position;

                    general.total.clicks += item.clicks;
                    general.total.impressions += item.impressions;
                    general.total.ctr += item.ctr;
                    general.total.position += item.position;
                });

                general.avg.clicks = general.total.clicks / dataAjax.length;
                general.avg.impressions = general.total.impressions / dataAjax.length;
                general.avg.ctr = general.total.ctr / dataAjax.length;
                general.avg.position = general.total.position / dataAjax.length;

                let listDataTemp = JSON.parse(JSON.stringify(listDataType));

                listDataTemp[0].value = numberToThousoun(general.total.clicks);
                listDataTemp[1].value = numberToThousoun(general.total.impressions);

                listDataTemp[2].value = ((general.avg.ctr * 100).toFixed(1) * 1).toString() + '%';
                listDataTemp[3].value = general.avg.position.toFixed(1) * 1;

                setListDataType(listDataTemp);

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

                let d, click, impressions, ctr, position;

                let dateStart = new Date(dataAjax[0].keys[0]);
                let dateEnd = new Date(dataAjax[dataAjax.length - 1].keys[0]);

                // To calculate the time difference of two dates 
                let Difference_In_Time = dateEnd.getTime() - dateStart.getTime();

                // To calculate the no. of days between two dates 
                let Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
                let randDate = Math.round(Difference_In_Days / 8);

                dataAjax.forEach((item, i) => {
                    d = new Date(item.keys[0]);

                    if (i % randDate === 0 || Difference_In_Days < 9) {
                        ticks.push(d);
                    }

                    let dataTemp = [
                        { v: d, f: weekday[d.getDay()] + ', ' + monthNames[d.getMonth()] + ' ' + d.getDate() }
                    ];

                    if (listDataType[0].active) {
                        dataTemp.push({ v: item.clicks * 82 / general.max.clicks, f: item.clicks.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") });
                    }

                    if (listDataType[1].active) {
                        dataTemp.push({ v: item.impressions * 100 / general.max.impressions, f: item.impressions.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") });
                    }

                    if (listDataType[2].active) {
                        dataTemp.push({ v: item.ctr * 70 / general.max.ctr, f: ((item.ctr * 100).toFixed(1) * 1) + '%' });
                    }

                    if (listDataType[3].active) {
                        dataTemp.push({ v: (general.max.position - (item.position - general.max.position)) * 40 / general.max.position, f: (item.position.toFixed(1) * 1).toString() });
                    }

                    dataUsers.push(dataTemp);

                });


                let data = new window.google.visualization.DataTable();
                data.addColumn('date', 'Date');

                let colorsTemplate = [];

                if (listDataType[0].active) {
                    data.addColumn('number', 'Clicks');
                    colorsTemplate.push(listDataType[0].color);
                }

                if (listDataType[1].active) {
                    data.addColumn('number', 'Impressions');
                    colorsTemplate.push(listDataType[1].color);
                }

                if (listDataType[2].active) {
                    data.addColumn('number', 'CTR');
                    colorsTemplate.push(listDataType[2].color);
                }

                if (listDataType[3].active) {
                    data.addColumn('number', 'Position');
                    colorsTemplate.push(listDataType[3].color);
                }

                data.addRows(dataUsers);
                let options = {
                    backgroundColor: 'transparent',
                    title: '',
                    colors: colorsTemplate,
                    chartArea: { left: 16, right: 16 },
                    tooltip: { isHtml: true, showColorCode: true },
                    pointSize: 4,
                    lineWidth: 2,
                    height: 300,
                    animation: {
                        duration: 800,
                        startup: true
                    },
                    crosshair: { orientation: 'vertical', trigger: 'focus', color: theme.palette.dividerDark },
                    focusTarget: 'category',
                    pointsVisible: false,
                    hAxis: { ticks: ticks, title: '', format: 'MMM d', textStyle: { fontSize: 12, color: theme.palette.text.secondary }, baselineColor: 'none', gridlines: { count: 4, color: 'transparent' } },
                    vAxis: { textPosition: 'none', format: 'short', textStyle: { fontWeight: 100, fontName: 'arial', fontSize: 12 }, minValue: 0, baselineColor: 'none', gridlines: { count: 4, color: theme.palette.dividerDark } },
                };
                let chart = new window.google.visualization.LineChart(document.getElementById('chart_search_by_date'));
                chart.draw(data, options);

            }
        });
    };

    React.useEffect(() => {

        if (loadScript && dataAjax) {

            loadChartOverview();

        }
    }, [dataAjax]);


    const unInActiveDataType = (i) => {
        let dataTemp = [...listDataType];
        let canChange = false;

        dataTemp.forEach((item, index) => {
            if (index !== i && item.active) {
                canChange = true;
                return;
            }
        });

        if (canChange) {
            dataTemp[i].active = !dataTemp[i].active;
            setListDataType(prev => dataTemp);
            loadChartOverview();
        }

    };


    return (
        <Card className={classes.root}>
            <CardContent style={{ padding: 0 }}>
                <div className={classes.overview}>
                    {
                        listDataType.map((item, i) => (
                            <div key={item.id} onClick={() => unInActiveDataType(i)} style={{ background: item.color }} className={'item' + ' ' + (item.active ? 'active' : '')}>
                                <Typography component="h3" variant="h3">
                                    {item.title}
                                </Typography>
                                <Typography component="h2" variant="h2" className={classes.title}>
                                    {item.value}
                                </Typography>
                                <div onClick={(e) => e.stopPropagation()}>
                                    <CustomTooltip interactive={true} key={item.id} title={<><strong>{item.title}</strong> {item.description}<br /><a target="_blank" href={item.linkHelper} color="default">LEARN MORE</a></>}   >
                                        <HelpOutlineIcon className='icon' style={{ color: item.active ? 'white' : 'rgba(0,0,0,0.54)' }} />
                                    </CustomTooltip>
                                </div>
                            </div>
                        ))
                    }
                </div>
                <div style={{ padding: '16px 16px 40px 16px', position: 'relative', minHeight: 250 }}>

                    {
                        dataAjax && loadScript ?
                            <div id="chart_search_by_date" style={{ height: 250 }}></div>
                            :
                            < CircularCustom />
                    }
                </div>
            </CardContent>
        </Card>
    )
}

export default ChartDate
