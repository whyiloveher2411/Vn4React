import { Card, CardContent, Grid } from '@material-ui/core'
import React from 'react'
import ActiveUserRightNow from '../compoments/Reports/ActiveUserRightNow';
import Device from '../compoments/Reports/Device';
import { useAjax } from 'utils/useAjax';
import { CircularCustom } from 'components';
import { useSelector } from 'react-redux';
import { addScript } from 'utils/helper';

function Main({ plugin }) {

    const settings = useSelector(state => state.settings);

    const [loadScript, setLoadScript] = React.useState(false);
    
    const [data, setData] = React.useState(false);

    const config = settings['google_analytics/analytics_api'];

    const { ajax } = useAjax();

    React.useEffect(() => {

        if (settings['google_analytics/analytics_api/active'] && config.complete_installation) {

            if (config.access_token_first) {

                addScript('https://www.gstatic.com/charts/loader.js', 'googleCharts', () => {
                    setLoadScript(true);
                });

                console.error = function () { };

                ajax({
                    url: 'plugin/' + plugin.key_word + '/dashboard/reports',
                    method: 'POST',
                    data: {
                        step: 'getDataRealtime'
                    },
                    success: (result) => {
                        if (!result.error) {
                            setData(result);
                        }
                    }
                });
            }
        }

    }, [settings]);

    if (!settings['google_analytics/analytics_api/active']) {
        return null;
    }

    return (
        <React.Fragment>
            <Grid
                item
                lg={4}
                sm={6}
                xs={12}
            >
                <Card style={{ height: '100%' }}>
                    <CardContent style={{ background: '#4285f4', minHeight: 460, height: '100%', position: 'relative' }}>
                        {
                            loadScript && data ?
                                <ActiveUserRightNow dataGA={data} google={window.google} />
                                :
                                <CircularCustom />
                        }
                    </CardContent>
                </Card>
            </Grid>

            <Grid
                item
                lg={3}
                sm={6}
                xs={12}
            >
                <Card style={{ height: '100%' }}>
                    <CardContent style={{ height: '100%', position: 'relative' }}>
                        {
                            loadScript && data ?
                                <Device dataGA2={data} showLinkReport={true} google={window.google} />
                                :
                                <CircularCustom />
                        }
                    </CardContent>
                </Card>
            </Grid>
        </React.Fragment>
    )
}

export default Main
