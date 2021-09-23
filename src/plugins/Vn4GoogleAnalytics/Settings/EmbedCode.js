import { Box, Card, CardContent } from '@material-ui/core';
import { FieldForm, LoadingButton, RedirectWithMessage } from 'components';
import SettingEdit1 from 'components/Setting/SettingEdit1';
import React from 'react';
import { checkPermission } from 'utils/user';

function EmbedCode({ meta, ajaxPluginHandle, loading }) {

    const [value, setValue] = React.useState(meta);

    const handleSubmitEmbedCode = () => {
        if (!loading.open) {
            ajaxPluginHandle({
                url: 'settings/setEmbedCode',
                data: {
                    step: 'setEmbedCode',
                    code: value['code-analytics'],
                }
            });
        }
    };

    if (!checkPermission('plugin_google_analytics_setting')) {
        return <RedirectWithMessage />
    }

    return (
        <SettingEdit1
            title="Embed Code"
            backLink="/plugin/vn4-google-analytics/settings"
            description="When you create your property, Analytics also generates a unique Tracking Code and a site-wide tag containing that Tracking Code for the generated property."
        >
            <Card>
                <CardContent>
                    <FieldForm
                        compoment='textarea'
                        config={{
                            title: 'Embed Code'
                        }}
                        post={value}
                        name={'code-analytics'}
                        onReview={(v) => setValue({ ...value, ['code-analytics']: v })}
                    />
                </CardContent>
            </Card>
            <br />
            <Box display="flex" justifyContent="flex-end">
                <LoadingButton
                    className={'btn-green-save'}
                    onClick={handleSubmitEmbedCode}
                    variant="contained"
                    open={loading.open}
                >
                    Save Changes
                </LoadingButton>
            </Box>
        </SettingEdit1>
    )
}

export default EmbedCode
