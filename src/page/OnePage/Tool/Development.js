import { Card, CardContent, Divider, Typography } from '@material-ui/core';
import Button from '@material-ui/core/Button';
import ClearRoundedIcon from '@material-ui/icons/ClearRounded';
import FileCopyIcon from '@material-ui/icons/FileCopy';
import CircularProgress from '@material-ui/core/CircularProgress';
import AddCircleOutlineOutlinedIcon from '@material-ui/icons/AddCircleOutlineOutlined';
import { ConfirmDialog, SettingGroup } from 'components';
import React from 'react';
import { useAjax } from 'utils/useAjax';

function Development() {

    const useAjax1 = useAjax();
    const useAjax2 = useAjax();
    const useAjax3 = useAjax();

    const [confirmDialog, setConfirmDialog] = React.useState(false);
    const [confirmDialog2, setConfirmDialog2] = React.useState(false);

    const deployAsset = () => {
        if (!useAjax1.open) {
            useAjax1.ajax({
                url: 'tool/development-asset',
                method: 'POST',
                success: (result) => {

                }
            });
        }
    }

    const refreshView = () => {
        if (!useAjax2.open) {
            useAjax2.ajax({
                url: 'tool/development-refresh-view',
                method: 'POST',
                success: (result) => {

                }
            });
        }
    }

    const compileCodeDI = () => {
        if (!useAjax3.open) {
            useAjax3.ajax({
                url: 'tool/compile-di',
                method: 'POST',
                success: (result) => {

                }
            });
        }
    }


    return (
        <SettingGroup
            title="Development"
            description="A database is an organized collection of data, generally stored and accessed electronically from a computer system."
        >
            <Card>
                <CardContent>

                    <Typography style={{ marginTop: 0 }} component="h2" className='settingTitle2' variant="h4" >Deploy Asset</Typography>
                    <Typography component="p" className='settingDescription' >
                        This is synchronizing your resource in the development with your copy in the real product
                    </Typography>
                    <Button
                        variant="contained"
                        color="primary"
                        startIcon={useAjax1.open ? <CircularProgress size={24} color={'inherit'} /> : <FileCopyIcon />}
                        className='margin'
                        onClick={() => setConfirmDialog(true)}
                    >
                        Deploy
                    </Button>

                    <ConfirmDialog open={confirmDialog} onClose={() => { setConfirmDialog(false) }} onConfirm={() => { deployAsset(); setConfirmDialog(false) }} message="Are you sure you want to synchronizing the resources" />
                    <Divider className='divider2' />

                    <Typography style={{ marginTop: 0 }} component="h2" className='settingTitle2' variant="h4" >Generate DI Code</Typography>
                    <Typography component="p" className='settingDescription' >
                        This is synchronizing your resource in the development with your copy in the real product
                    </Typography>
                    <Button
                        variant="contained"
                        color="primary"
                        startIcon={useAjax3.open ? <CircularProgress size={24} color={'inherit'} /> : <AddCircleOutlineOutlinedIcon />}
                        className='margin'
                        onClick={() => setConfirmDialog2(true)}
                    >
                        Generate
                    </Button>
                    <ConfirmDialog open={confirmDialog2} onClose={() => { setConfirmDialog2(false) }} onConfirm={() => { compileCodeDI(); setConfirmDialog2(false) }} message="Are you sure you want to Compile Code." />
                    <Divider className='divider2' />

                    <Typography component="h2" className='settingTitle2' variant="h4" >Refresh views</Typography>
                    <Typography component="p" className='settingDescription' >
                        clears the cache for all existing views
                    </Typography>
                    <Button
                        variant="contained"
                        color="primary"
                        startIcon={useAjax2.open ? <CircularProgress size={24} color={'inherit'} /> : <ClearRoundedIcon />}
                        className='margin'
                        onClick={refreshView}
                    >
                        Refresh
                    </Button>
                </CardContent>
            </Card>
        </SettingGroup>
    )
}
export default Development
