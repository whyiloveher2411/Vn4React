import { Card, CardContent, CardHeader } from '@material-ui/core';
import { Skeleton } from '@material-ui/lab';
import MoreButton from 'components/MoreButton';
import { PLUGIN_NAME } from 'plugins/Vn4Ecommerce/helpers/plugin';
import React from 'react';
import { __p } from 'utils/i18n';

function ReportsSales({ data, time }) {

    if (data) {
        return (
            <Card>
                <CardHeader
                    action={
                        <MoreButton
                            title={__p('Change time', PLUGIN_NAME)}
                            action={data.time.time_report}
                            selected={time}
                            autoFocus={false}
                        />
                    }
                    title="Reports Sales"
                    subheader={data.time.time_report[0][time].title}
                />
                <CardContent>
                    <div id="chart_reports_sales"></div>
                </CardContent>
            </Card>
        )
    }
    return (
        <Card>
            <CardHeader
                title={<Skeleton variant="rect" width={'100%'} style={{ marginBottom: 5 }} height={19} />}
                subheader={<Skeleton variant="rect" width={'100%'} height={17} />}
            />
            <CardContent>
                <Skeleton variant="rect" width={'100%'} height={200} />
            </CardContent>
        </Card>
    )
}

export default ReportsSales
