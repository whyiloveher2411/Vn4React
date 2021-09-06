import { Divider, Typography } from '@material-ui/core';
import BookmarkIcon from '@material-ui/icons/Bookmark';
import React from 'react';
import { convertMSTime, findLinkMessage, scoreLabel } from '../../helper';
import CircularChart from './CircularChart';
import MetricDetail from './MetricDetail';

const LinkCoreWebVital = ({ children }) => {
    return <a href="https://web.dev/vitals/" rel="noreferrer" target="_blank"><BookmarkIcon style={{ float: 'left', height: 18 }} /> {children}</a>
}


function Performance({ dataOrigin }) {

    const [data, setData] = React.useState(false);

    const fieldDataStt = {
        fieldData: [
            { title: 'First Contentful Paint (FCP)', key: 'FIRST_CONTENTFUL_PAINT_MS' },
            { title: 'First Input Delay (FID)', key: 'FIRST_INPUT_DELAY_MS', isCoreWebVital: true },
            { title: 'Largest Contentful Paint (LCP)', key: 'LARGEST_CONTENTFUL_PAINT_MS', isCoreWebVital: true },
            { title: 'Cumulative Layout Shift (CLS)', key: 'CUMULATIVE_LAYOUT_SHIFT_SCORE', notTime: true, isCoreWebVital: true },
        ],
        labData: [
            { title: 'First Contentful Paint', key: 'first-contentful-paint' },
            { title: 'Time to Interactive', key: 'interactive' },
            { title: 'Speed Index', key: 'speed-index' },
            { title: 'Total Blocking Time', key: 'total-blocking-time' },
            { title: 'Largest Contentful Paint', key: 'largest-contentful-paint', isCoreWebVital: true },
            { title: 'Cumulative Layout Shift', key: 'cumulative-layout-shift', isCoreWebVital: true },
        ]
    };

    React.useEffect(() => {
        if (dataOrigin) {
            let groups = {
                'load-opportunities': {
                    title: dataOrigin.lighthouseResult.categoryGroups['load-opportunities'].title,
                    description: findLinkMessage(dataOrigin.lighthouseResult.categoryGroups['load-opportunities'].description),
                    notShowCount: true,
                    displayValue: false,
                    sort: 'desc',
                    keys: {}
                },
                'diagnostics': {
                    title: dataOrigin.lighthouseResult.categoryGroups['diagnostics'].title,
                    description: findLinkMessage(dataOrigin.lighthouseResult.categoryGroups['diagnostics'].description),
                    notShowCount: true,
                    displayValue: true,
                    sort: 'asc',
                    keys: {}
                },
            };

            let groups2 = {
                'passed': {
                    title: dataOrigin.lighthouseResult.i18n.rendererFormattedStrings.passedAuditsGroupTitle,
                    displayValue: true,
                    sort: 'asc',
                    keys: []
                },
                'notApplicable': {
                    title: dataOrigin.lighthouseResult.i18n.rendererFormattedStrings.notApplicableAuditsGroupTitle,
                    displayValue: true,
                    sort: 'asc',
                    keys: []
                },
            };

            dataOrigin.lighthouseResult.categories.performance.auditRefs.forEach(item => {
                if (item.group && groups[item.group]) {
                    if (dataOrigin.lighthouseResult.audits[item.id].score >= 0.9) {
                        groups2.passed.keys.push(item.id)
                    } else {
                        if (dataOrigin.lighthouseResult.audits[item.id].scoreDisplayMode === 'notApplicable') {
                            groups2.notApplicable.keys.push(item.id);
                        } else {
                            if (groups[item.group].sort === 'desc') {
                                groups[item.group].keys[item.id] = dataOrigin.lighthouseResult.audits[item.id].numericValue;
                            } else {
                                groups[item.group].keys[item.id] = dataOrigin.lighthouseResult.audits[item.id].score ?? 1;
                            }
                        }
                    }
                }
            });

            Object.keys(groups).forEach(item => {
                let keys = Object.keys(groups[item].keys);

                if (groups[item].sort === 'desc') {
                    keys.sort(function (a, b) {
                        return groups[item].keys[b] - groups[item].keys[a];
                    });
                } else {
                    keys.sort(function (a, b) {
                        return groups[item].keys[a] - groups[item].keys[b];
                    });
                }

                groups[item].keys = keys;
            });

            setData({ ...dataOrigin, groups: { ...groups, ...groups2 } });

        }
    }, [dataOrigin]);

    return (
        <div >
            <div className='reportSummary'>
                <CircularChart scrore={data ? data.lighthouseResult.categories.performance.score : 0} />
                <Typography component="h2" gutterBottom style={{ textAlign: 'center' }} variant="h3">{data && data.lighthouseResult.finalUrl}</Typography>
                <div className='scorescale'>
                    <span style={{ '--color': 'var(--color-slow)' }}>0–49</span>
                    <span style={{ '--color': 'var(--color-average)' }}>50–89</span>
                    <span style={{ '--color': 'var(--color-fast)' }}>90–100</span>
                </div>
            </div>
            <Divider className='divider' />
            <div className='fieldData'>



                <Typography className="audit-group-header" component="h2" gutterBottom variant="h5">Field Data</Typography>

                <div className='metrics-container'>
                    {
                        data && data.loadingExperience.metrics &&
                        fieldDataStt.fieldData.map((item, i) => (
                            <div className={'metric-wrapper ' + data.loadingExperience.metrics[item.key].category.toLowerCase()} key={i} >
                                <div className={'field-metric'}>
                                    <span className='metric-description' style={{
                                        display: 'flex',
                                        alignItems: 'center'
                                    }}>{item.title} {item.isCoreWebVital && <LinkCoreWebVital />}</span>
                                    <span className='metric-value'>{item.notTime ? (data.loadingExperience.metrics[item.key].percentile / 100) : convertMSTime(data.loadingExperience.metrics[item.key].percentile)}</span>
                                </div>
                                <div className='metric-chart'>
                                    {
                                        data.loadingExperience.metrics[item.key].distributions.map((item2, i2) => (
                                            (item2.proportion * 100).toFixed(0) > 0 ?
                                                <div key={i2} className={'bar ' + (i2 === 0 ? 'fast' : i2 === 1 ? 'average' : 'slow')} style={{ '--color': 'var(--color-' + (i2 === 0 ? 'fast' : i2 === 1 ? 'average' : 'slow') + ')', flexGrow: (item2.proportion * 100).toFixed(0) }}>{(item2.proportion * 100).toFixed(0)}%</div>
                                                :
                                                <React.Fragment key={i2}></React.Fragment>
                                        ))
                                    }
                                </div>
                            </div>
                        ))
                    }
                </div>
            </div>

            <div className='fieldData'>
                <Typography className="audit-group-header" component="h2" gutterBottom variant="h5">Lab Data</Typography>
                <div className='metrics-container lh-metric'>
                    {
                        data &&
                        fieldDataStt.labData.map((item) => (
                            <div className={'metric-wrapper ' + scoreLabel(data.lighthouseResult.audits[item.key].score)} id={item.key} key={item.key} >
                                <div className="field-metric">
                                    <span className='metric-description' style={{
                                        display: 'flex',
                                        alignItems: 'center'
                                    }}>{data.lighthouseResult.audits[item.key].title} {item.isCoreWebVital && <LinkCoreWebVital />}</span>
                                    <span className='metric-value'>{data.lighthouseResult.audits[item.key].displayValue}</span>
                                </div>
                            </div>
                        ))
                    }
                </div>
                <Typography className="audit-group-header" style={{ marginTop: 8 }} component="h2" gutterBottom variant="h5"><span className="audit-description">Values are estimated and may vary. The performance score is calculated directly from these metrics.See calculator.</span></Typography>
            </div>

            <div className='fieldData'>
                <div className='metrics-container' style={{ display: 'flex', justifyContent: 'center' }} id="screenshot-thumbnails">
                    {
                        data &&
                        data.lighthouseResult.audits['screenshot-thumbnails'].details.items.map((item, i) => (
                            <div className='thumbnail' key={i}>
                                <img src={item.data} title={item.timing} alt={item.timing} />
                            </div>
                        ))
                    }
                </div>
            </div>

            {
                data &&
                <div className="finaly-screenshot"><img src={data.lighthouseResult.audits['final-screenshot'].details.data} alt='final screentshot' /></div>
            }
            <br />
            {
                data &&
                Object.keys(data.groups).map(key => (
                    data.groups[key].keys.length ?
                        <div key={key} className='fieldData'>
                            <Typography className="audit-group-header" component="h2" gutterBottom variant="h5">{data.groups[key].title} {
                                !data.groups[key].notShowCount &&
                                `(${data.groups[key].keys.length})`
                            }
                                {
                                    data.groups[key].description &&
                                    <> -  <span className="audit-description" dangerouslySetInnerHTML={{ __html: data.groups[key].description }} />
                                    </>
                                }
                            </Typography>
                            <div className='metrics-container' style={{ display: 'block' }}>
                                {
                                    data.groups[key].keys.map((key2) => (
                                        <MetricDetail key={key2} data={data.lighthouseResult.audits[key2]} item={key2} displayValue={data.groups[key].displayValue} />
                                    ))
                                }
                            </div>

                        </div>
                        :
                        <React.Fragment key={key}></React.Fragment>
                ))
            }
        </div>
    )
}

export default Performance
