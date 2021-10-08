import { Button, Card, CardContent, Typography } from '@material-ui/core';
import CheckRoundedIcon from '@material-ui/icons/CheckRounded';
import { SettingGroup } from 'components';
import CircularProgress from '@material-ui/core/CircularProgress';
import React from 'react';
import { useAjax } from 'utils/useAjax';
import { minifyHTML } from './optimizeAction';
import { __ } from 'utils/i18n';

function Optimize() {

    const useAjax1 = useAjax();

    const handleMinifyHTML = () => {
        if (!useAjax1.open) {
            minifyHTML(useAjax1.ajax);
        }
    }

    return (
        <SettingGroup
            title={__('Optimize')}
            description={__('Optimizing your site\'s settings and source code will save bandwidth and speed up your site\'s loading, thus saving you money and improving the user experience.')}
        >
            <Card>
                <CardContent>
                    <Typography style={{ marginTop: 0 }} component="h2" className='settingTitle2' variant="h4" >{__('Minify HTML')} </Typography>
                    <Typography component="p" className='settingDescription' >
                        {__('Minification is the process of minimizing code and markup in your web pages and script files. It’s one of the main methods used to reduce load times and bandwidth usage on websites')}
                    </Typography>
                    <Button
                        variant="contained"
                        color="primary"
                        className='margin'
                        onClick={handleMinifyHTML}
                        startIcon={useAjax1.open ? <CircularProgress size={24} color={'inherit'} /> : <CheckRoundedIcon />}
                    >
                        {__('Check')}
                    </Button>
                </CardContent>
            </Card>
        </SettingGroup>
    )
}
export default Optimize
