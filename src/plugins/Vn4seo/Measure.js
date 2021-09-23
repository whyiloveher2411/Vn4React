import { Card, CardContent, colors, Divider, Grid, makeStyles, Tab, Tabs, TextField, Typography } from '@material-ui/core';
import Button from '@material-ui/core/Button';
import LaptopIcon from '@material-ui/icons/Laptop';
import SmartphoneIcon from '@material-ui/icons/Smartphone';
import { Alert, AlertTitle } from '@material-ui/lab';
import { PageHeaderSticky } from 'components/Page';
import RedirectWithMessage from 'components/RedirectWithMessage';
import React from 'react';
import { Redirect, useHistory, useRouteMatch } from 'react-router-dom';
import { checkPermission } from 'utils/user';
import { getUrlParams } from '../../utils/herlperUrl';
import Accessibility from './compoments/Measure/Accessibility';
import BestPractices from './compoments/Measure/BestPractices';
import Performance from './compoments/Measure/Performance';
import SEO from './compoments/Measure/SEO';

const useStyles = makeStyles((theme) => ({
    root: {
        '--color-fast': '#0cce6b',
        '--color-average': '#ffa400',
        '--color-slow': '#ff4e42',
        '--color-fast-secondary': '#018642',
        '--color-average-secondary': '#d04900',
        '--color-slow-secondary': '#eb0f00',
        '--report-text-color-secondary': '#424242',
        minHeight: 700,
        '& :link, & :visited': {
            color: '#3367d6',
        },
        '& .fast': {
            '--background': 'var(--color-fast)',
            '--color': 'var(--color-fast-secondary)',
        },
        '& .slow': {
            '--background': 'var(--color-slow)',
            '--color': 'var(--color-slow-secondary)',
        },
        '& .average': {
            '--background': 'var(--color-average)',
            '--color': 'var(--color-average-secondary)',
        },
        '& .notapplicable': {
            '--background': '#bdbdbd',
            '--color': '#bdbdbd',
        },
        '& .audit-description': {
            color: theme.palette.text.third,
            fontWeight: 'normal',
            lineHeight: '24px',
        },
        '& .finaly-screenshot': {
            marginTop: 16,
            textAlign: 'center',
        },
        '& .metrics-container': {
            display: 'grid',
            gridTemplateColumns: '1fr 1fr',
            gridColumnGap: '24px'
        },
        '& .metrics-container .thumbnail img': {
            maxHeight: 100,
            maxWidth: 60,
            border: '1px solid ' + theme.palette.dividerDark,
        },
        '& .audit-group-header': {
            marginBottom: 8,
            fontWeight: 'bold',
        },
        '& .field-details .field-description': {
            padding: '8px 10px 8px 28px',
            color: 'var(--report-text-color-secondary)',
            lineHeight: '24px',
        },
        '& .field-metric': {
            fontWeight: '500',
            paddingTop: 12,
            paddingBottom: 12,
            justifyContent: 'space-between',
            display: 'grid',
            gridTemplateColumns: '10fr 3fr',
            padding: '10px 0',
            cursor: 'pointer',
            '& .metric-description': {
                flex: 1,
                paddingLeft: 28,
                lineHeight: '24px',
            },
            '&:before': {
                content: '""',
                width: 10,
                height: 10,
                display: 'inline-block',
                margin: '0 10px 0 4px',
                background: 'var(--background)',
                position: 'absolute',
                marginTop: 3
            },
            '& .metric-value': {
                whiteSpace: 'nowrap',
                fontWeight: 500,
                justifySelf: 'end',
                color: 'var(--color)',
            },
        },
        '& .metric-wrapper': {
            borderTop: '1px solid ' + theme.palette.dividerDark,
            borderBottom: '1px solid ' + theme.palette.dividerDark,
            marginTop: '-1px',
        },
        '& .fast .field-metric:before, & .notapplicable .field-metric:before': {
            borderRadius: '100%',
        },
        '& .slow .field-metric:before': {
            borderLeft: '6px solid transparent',
            borderRight: '6px solid transparent',
            borderBottom: '12px solid var(--background)',
            background: 'none',
            width: 0, height: 0,
        },
        '& .metric-chart': {
            display: 'flex',
            fontSize: 14,
            marginLeft: '28px',
            paddingBottom: '16px',
            fontWeight: 400,
        },
        '& .metric-chart .bar': {
            display: 'inline-block',
            lineHeight: '24px',
            color: '#fff',
            borderRadius: '12px 0 0 12px',
            textAlign: 'left',
            paddingLeft: 10,
            minWidth: 38,
            position: 'relative',
            backgroundColor: 'var(--color)',
            fontWeight: 500,
            '&::after': {
                width: 12,
                height: 24,
                position: 'absolute',
                right: '-12px',
                content: '""',
                backgroundColor: 'var(--color)',
            },
            '&:last-child': {
                borderRadius: 12,
                '&::after': {
                    content: 'none',
                }
            },
            '&.average': {
                backgroundColor: 'var(--color-average)',
                color: '#000',
            },
        },
        '& .field-table': {
            paddingLeft: 28,
            '& table': {
                width: '100%'
            },
            '& h4': {
                margin: '8px 0',
            },
            '& th': {
                color: theme.palette.text.third,
                padding: '8px 2px',
            },
            '& td': {
                padding: '8px 2px'
            },
            '& .lh-table-column--url,& .lh-table-column--link,& .lh-table-column--text,& .lh-table-column--node': {
                textAlign: 'left',
            },
            '& .lh-table-column--thumbnail': {
                width: 48,
            },
            '& .dt--thumbnail img': {
                objectFit: 'cover',
                width: 48,
                height: 48,
                display: 'block'
            },
            '& .dt--url a,& .dt--link a:not(.link)': {
                color: 'inherit',
            },
            '& .lh-table-column--bytes,& .lh-table-column--timespanMs,& .lh-table-column--ms,& .lh-table-column--numeric': {
                // width: '12%',
                textAlign: 'right',
            },
            '& .dt--node code': {
                color: '#0938c2',
                wordBreak: 'break-all',
            },
            '& .dt--bytes,& .dt--timespanMs,& .dt--ms,& .dt--numeric': {
                textAlign: 'right',
                fontWeight: '500',
            },
        },
        '& .reportSummary': {
            display: 'flex',
            flexDirection: 'column',
            alignItems: 'center',
        },
        '& .scorescale': {
            display: 'inline-flex',
            padding: 8,
            border: '1px solid #e0e0e0',
            borderRadius: '20px',
            '& span': {
                display: 'inline-flex',
                margin: '0 12px',
                alignItems: 'center',
                '&::before': {
                    content: '""',
                    display: 'inline-block',
                    height: 6,
                    width: 16,
                    background: 'var(--color)',
                    marginRight: 8,
                    borderRadius: 20,
                }
            }
        },
        '& .fieldData': {
            maxWidth: 760,
            position: 'relative',
            margin: '0 auto 40px',
        },
        '& code': {
            color: 'rgb(9, 56, 194)',
            margin: '0 8px',
        },
        '& .divider': {
            backgroundColor: theme.palette.dividerDark,
            margin: '16px 0',
        },
    },
    cardContent: {
        position: 'relative',
        minHeight: 450,
    },
    cardLoading: {
        position: 'absolute',
        left: 0,
        top: 0,
        height: '100%',
        width: '100%',
        display: 'flex',
        alignItems: 'flex-start',
        paddingTop: 300,
        justifyContent: 'center',
        background: 'rgba(0,0,0,0.12)',
    },
    title: {
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'space-between'
    },
    alert: {
        marginBottom: 16,
        borderRadius: 0,
        '& .alert-content': {
            display: 'flex'
        },
        '& .MuiAlert-icon': {
            paddingTop: 10,
        }
    },
}));

function Measure({ meta, ajaxPluginHandle, loading }) {

    const classes = useStyles();

    const history = useHistory();
    const match = useRouteMatch();

    const queryDevice = getUrlParams(window.location.search, 'device');

    const [website, setWebsite] = React.useState(meta.searchConsoleWebsites ? meta.searchConsoleWebsites[0] : false);

    const strategys = { mobile: 1, desktop: 1 };

    const [strategy, setStrategy] = React.useState(strategys[queryDevice] ? queryDevice : 'mobile');
    const [data, setData] = React.useState({});

    const { subtab } = match.params;

    const permission = checkPermission('plugin_vn4seo_view_measure');

    const tabs = {
        performance: { value: 'performance', label: 'Performance' },
        seo: { value: 'seo', label: 'SEO' },
        'best-practices': { value: 'best_practices', label: 'Best Practices' },
        accessibility: { value: 'accessibility', label: 'Accessibility' },
    };

    React.useEffect(() => {
        if (website && subtab && tabs[subtab] && permission) {
            getData();
        }
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [website, subtab, strategy]);

    const getData = () => {

        if (!data[website + ' ' + subtab + '_' + strategy]) {
            ajaxPluginHandle({
                url: 'dashboard/google-speed',
                data: {
                    url: website,
                    strategy: strategy,
                    category: tabs[subtab].value,
                    locale: 'en_US',
                },
                success: function (result) {

                    if (result.id) {
                        setData({ ...data, [subtab + '_' + strategy]: result });
                    }
                }
            });
        }
    };

    const handleTabsChange = (event, value) => {
        history.push(value);
    }

    if (!website) {
        if (!website) {
            return <RedirectWithMessage
                message="Please install google analytics before using this feature!"
                to="/plugin/vn4seo/settings"
                variant="warning" />
        }
    }

    if (!permission) {
        return <RedirectWithMessage />
    }

    if (!subtab) {
        return <Redirect to="/plugin/vn4seo/measure/performance" />;
    }

    if (!tabs[subtab]) {
        return <Redirect to="/plugin/vn4seo/measure/performance" />;
    }
    return (
        <PageHeaderSticky
            title="Measure"
            header={
                <Grid
                    container
                    className={classes.grid}
                    justify="space-between"
                    alignItems="center"
                    spacing={3}>
                    <Grid item xs={12}>
                        <Typography component="h2" gutterBottom variant="overline">Vn4 SEO</Typography>
                        <Typography component="div" variant="h3" className={classes.title}>
                            Measure
                        </Typography>
                    </Grid>
                </Grid>
            }
        >
            <div style={{ display: 'flex', marginBottom: 16 }}>
                <TextField defaultValue={website} onChange={(e) => { if (e.target.value) data.website = e.target.value; }} fullWidth style={{ paddingRight: 5 }} size="small" id="outlined-basic" label="URL" placeholder="Enter a webpage URL" variant="outlined" />
                <Button variant="contained" onClick={() => { if (data.website) setWebsite(data.website) }} color="primary">
                    Analyze
                </Button>
            </div>
            <Tabs
                className={classes.tabs}
                onChange={handleTabsChange}
                scrollButtons="auto"
                value={subtab}
                indicatorColor="primary"
                textColor="primary"
                variant="scrollable">
                {Object.keys(tabs).map((key) => (
                    <Tab key={key} label={tabs[key].label} value={key} />
                ))}
            </Tabs>
            <Divider className={classes.divider} style={{ margin: 0 }} />
            <Card className={classes.cardContent} >
                {
                    loading.open &&
                    <div className={classes.cardLoading}>{loading.compoment}</div>
                }
                <Tabs
                    className={classes.tabs}
                    onChange={(event, value) => setStrategy(value)}
                    scrollButtons="auto"
                    value={strategy}
                    indicatorColor="primary"
                    textColor="primary"
                    variant="scrollable">
                    <Tab value={'mobile'} aria-label="phone" label={<span style={{ display: 'flex' }}><SmartphoneIcon />&nbsp;Mobile</span>} />
                    <Tab value={'desktop'} aria-label="laptop" label={<span style={{ display: 'flex' }}><LaptopIcon />&nbsp;Desktop</span>} />
                </Tabs>
                {
                    data[subtab + '_' + strategy]?.lighthouseResult?.runWarnings[0] &&
                    <Alert className={classes.alert} severity="warning">
                        <AlertTitle style={{ color: '#bd4200' }}>There were issues affecting this run of Lighthouse:</AlertTitle>
                        {
                            data[subtab + '_' + strategy].lighthouseResult.runWarnings.map((item, i) => (
                                <p key={i}>{item}</p>
                            ))
                        }
                    </Alert>
                }
                <CardContent className={classes.root}>
                    {subtab === 'performance' && <Performance dataOrigin={data['performance_' + strategy]} />}
                    {subtab === 'seo' && <SEO dataOrigin={data['seo_' + strategy]} />}
                    {subtab === 'best-practices' && <BestPractices dataOrigin={data['best-practices_' + strategy]} />}
                    {subtab === 'accessibility' && <Accessibility dataOrigin={data['accessibility_' + strategy]} />}
                </CardContent>
            </Card>
        </PageHeaderSticky >
    )
}

export default Measure
