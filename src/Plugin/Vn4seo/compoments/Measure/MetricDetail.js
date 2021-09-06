import React from 'react'
import { scoreLabel, convertMSTime, formatBytes, getValueType, findLinkMessage } from '../../helper';
import { findCode } from '../../helper';

const ThirdPartySummary = ({ data, item }) => {
    return (
        <>
            {
                data.details.items.map((i, index) => (
                    <React.Fragment key={index}>
                        <tr key={index}>
                            <td className="lh-table-column--text"><h4><a target="_blank" rel="noreferrer" href={i.entity.url}>{i.entity.text}</a></h4></td>
                            <td className="lh-table-column--bytes"><div className="dt--bytes">{formatBytes(i.transferSize)}</div></td>
                            <td className="lh-table-column--ms"><div className="dt--ms">{convertMSTime(i.blockingTime)}</div></td>
                        </tr>
                        {
                            i.subItems.items.map((i2, index2) => (
                                <tr key={index2}>
                                    <td className="lh-table-column--url"><div className="dt--url"><a href={i2.url} rel="noreferrer" target="_blank">...{i2.url.substring(i2.url.length - 30, i2.url.length)}</a></div></td>
                                    <td className="lh-table-column--bytes"><div className="dt--bytes">{formatBytes(i2.transferSize)}</div></td>
                                    <td className="lh-table-column--ms"><div className="dt--ms">{convertMSTime(i2.blockingTime)}</div></td>
                                </tr>
                            ))
                        }
                    </React.Fragment>
                ))
            }
        </>
    );
};

function MetricDetail({ data, item, displayValue, notShowValue }) {
    const [open, setOpen] = React.useState(false);
    return (
        <div className={'metric-wrapper ' + scoreLabel(data.score)} id={item} key={item} >
            <div className="field-metric" onClick={() => setOpen(!open)}>
                <span className='metric-description' dangerouslySetInnerHTML={{ __html: findCode(data.title) }} />
                {
                    displayValue && data.displayValue ?
                        <span className='metric-value'>{data.displayValue}</span>
                        :
                        data.numericValue ?
                            <span className='metric-value'>{convertMSTime(data.numericValue)}</span>
                            : <></>
                }
            </div>
            {
                open &&
                <div className="field-details">
                    <div className="field-description" dangerouslySetInnerHTML={{
                        __html: findLinkMessage(data.description)
                    }} />
                    <div className="field-table">
                        {
                            data.details?.headings &&
                            <table>
                                <thead>
                                    <tr>
                                        {
                                            data.details.headings.map((item, i) => (
                                                <th className={'lh-table-column--' + (item.valueType || item.itemType)} key={i}>{item.label || item.text}</th>
                                            ))
                                        }
                                    </tr>
                                </thead>
                                <tbody>
                                    {
                                        item === 'third-party-summary'
                                            ?
                                            <ThirdPartySummary formatBytes={formatBytes} data={data} item={item} />
                                            :
                                            data.details.items.map((item, i) => (
                                                <tr key={i}>
                                                    {
                                                        data.details.headings.map((th, i2) => (
                                                            <td key={i2} className={'lh-table-column--' + th.valueType} ><div className={'dt--' + (th.valueType || th.itemType)} dangerouslySetInnerHTML={{ __html: getValueType(item[th.key], th.valueType || th.itemType) }}></div></td>
                                                        ))
                                                    }
                                                </tr>
                                            ))
                                    }
                                </tbody>
                            </table>
                        }
                    </div>
                </div>
            }
        </div>

    );
}

export default MetricDetail
