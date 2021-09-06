import { Button, Card, CardContent, Typography } from '@material-ui/core';
import CheckRoundedIcon from '@material-ui/icons/CheckRounded';
import { SettingGroup } from 'components';
import CircularProgress from '@material-ui/core/CircularProgress';
import React from 'react';
import { useAjax } from 'utils/useAjax';

function Optimize() {

    const useAjax1 = useAjax();

    const minifyHtml = () => {
        if (!useAjax1.open) {
            useAjax1.ajax({
                url: 'tool/optimize-minify-html',
                method: 'POST',
                isGetData: false,
                success: (result) => {

                }
            });
        }
    }

    return (
        <SettingGroup
            title="Optimize"
            description="A database is an organized collection of data, generally stored and accessed electronically from a computer system."
        >
            <Card>
                <CardContent>
                    <Typography style={{ marginTop: 0 }} component="h2" className='settingTitle2' variant="h4" >Minify HTML </Typography>
                    <Typography component="p" className='settingDescription' >
                        Minification is the process of minimizing code and markup in your web pages and script files. It’s one of the main methods used to reduce load times and bandwidth usage on websites
                    </Typography>
                    <Button
                        variant="contained"
                        color="primary"
                        className='margin'
                        onClick={minifyHtml}
                        startIcon={useAjax1.open ? <CircularProgress size={24} color={'inherit'} /> : <CheckRoundedIcon />}
                    >
                        Minify
                    </Button>
                </CardContent>
            </Card>
        </SettingGroup>
    )
}
export default Optimize
