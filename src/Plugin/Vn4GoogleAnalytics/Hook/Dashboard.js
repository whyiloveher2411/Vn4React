import { Card, CardContent, Grid } from '@material-ui/core'
import React from 'react'
import ActiveUserRightNow from './../compoments/Reports/ActiveUserRightNow';
import Device from './../compoments/Reports/Device';
import { useAjax } from 'utils/useAjax';
import { CircularCustom } from 'components';

function Dashboard({ plugin }) {

    const [loadScript, setLoadScript] = React.useState(false);
    const [data, setData] = React.useState(false);


    let meta = {};

    if (plugin.meta) {
        meta = JSON.parse(plugin.meta);
    }

    if (!meta) {
        meta = {};
    }

    const {ajax} = useAjax();

    React.useEffect(() => {

        if (meta.access_token_first) {

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
    }, []);

    if (!meta.access_token_first) {
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

export default Dashboard
