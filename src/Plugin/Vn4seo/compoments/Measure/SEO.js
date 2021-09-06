import { Divider, Typography } from '@material-ui/core'
import React from 'react'
import CircularChart from './CircularChart'
import MetricDetail from './MetricDetail';
import { findLinkMessage } from '../../helper';

function SEO({ dataOrigin }) {

    const [data, setData] = React.useState(false);

    const type = 'seo';

    const group = [];

    React.useEffect(() => {

        if (dataOrigin) {

            let groups = {
                'seo-content': {
                    title: dataOrigin.lighthouseResult.categoryGroups['seo-content'].title,
                    description: findLinkMessage(dataOrigin.lighthouseResult.categoryGroups['seo-content'].description),
                    notShowCount: true,
                    keys: {}
                },
                'seo-crawl': {
                    title: dataOrigin.lighthouseResult.categoryGroups['seo-crawl'].title,
                    description: findLinkMessage(dataOrigin.lighthouseResult.categoryGroups['seo-crawl'].description),
                    notShowCount: true,
                    keys: {}
                },
                'seo-mobile': {
                    title: dataOrigin.lighthouseResult.categoryGroups['seo-mobile'].title,
                    description: findLinkMessage(dataOrigin.lighthouseResult.categoryGroups['seo-mobile'].description),
                    notShowCount: true,
                    keys: {}
                },
                'undefined': {
                    title: dataOrigin.lighthouseResult.i18n.rendererFormattedStrings.manualAuditsGroupTitle,
                    description: findLinkMessage(dataOrigin.lighthouseResult.categories.seo.manualDescription),
                    keys: []
                },
            };

            let groups2 = {
                'passed': {
                    title: dataOrigin.lighthouseResult.i18n.rendererFormattedStrings.passedAuditsGroupTitle,
                    keys: []
                },
                'notApplicable': {
                    title: dataOrigin.lighthouseResult.i18n.rendererFormattedStrings.notApplicableAuditsGroupTitle,
                    keys: []
                },
            };

            dataOrigin.lighthouseResult.categories.seo.auditRefs.forEach(item => {
                if (dataOrigin.lighthouseResult.audits[item.id].score >= 0.9) {
                    groups2.passed.keys.push(item.id)
                } else {
                    if (dataOrigin.lighthouseResult.audits[item.id].scoreDisplayMode === 'notApplicable') {
                        groups2.notApplicable.keys.push(item.id);
                    } else {
                        groups[item.group].keys[item.id] = dataOrigin.lighthouseResult.audits[item.id].score;
                    }
                }
            });

            Object.keys(groups).forEach(item => {
                let keys = Object.keys(groups[item].keys);

                keys.sort(function (a, b) {
                    return groups[item].keys[a] - groups[item].keys[b];
                });

                groups[item].keys = keys;
            });

            setData({ ...dataOrigin, groups: { ...groups, ...groups2 } });
        }
    }, [dataOrigin]);

    return (
        <div >
            <div className='reportSummary'>
                <CircularChart scrore={data ? data.lighthouseResult.categories[type].score : 0} />
                <Typography component="h2" gutterBottom style={{ textAlign: 'center' }} variant="h3">{data && data.lighthouseResult.finalUrl}</Typography>
                <div className='scorescale'>
                    <span style={{ '--color': 'var(--color-slow)' }}>0–49</span>
                    <span style={{ '--color': 'var(--color-average)' }}>50–89</span>
                    <span style={{ '--color': 'var(--color-fast)' }}>90–100</span>
                </div>
            </div>
            <Divider className='divider' />
            <br />
            <Typography className="fieldData" component="h2" gutterBottom style={{ textAlign: 'center' }} variant="body1" dangerouslySetInnerHTML={{ __html: data ? findLinkMessage(data.lighthouseResult.categories.seo.description) : '' }} />

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
                                        <MetricDetail key={key2} data={data.lighthouseResult.audits[key2]} item={key2} displayValue />
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

export default SEO
