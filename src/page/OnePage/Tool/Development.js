import { Card, CardContent, Divider, Typography } from '@material-ui/core';
import Button from '@material-ui/core/Button';
import CircularProgress from '@material-ui/core/CircularProgress';
import AddCircleOutlineOutlinedIcon from '@material-ui/icons/AddCircleOutlineOutlined';
import CheckRoundedIcon from '@material-ui/icons/CheckRounded';
import FileCopyIcon from '@material-ui/icons/FileCopy';
import RefreshOutlinedIcon from '@material-ui/icons/RefreshOutlined';
import { ConfirmDialog, SettingGroup } from 'components';
import React from 'react';
import { getLanguages, __ } from 'utils/i18n';
import { useAjax } from 'utils/useAjax';
import { checkLanguage, compileCodeDI, deployAsset, refreshView } from './developmentAction';

function Development() {

    const useAjax1 = useAjax();
    const useAjax2 = useAjax();
    const useAjax3 = useAjax();
    const useAjax4 = useAjax();

    const [confirmDialog, setConfirmDialog] = React.useState(false);
    const [confirmDialog2, setConfirmDialog2] = React.useState(false);

    const handleDeployAsset = () => {
        if (!useAjax1.open) {
            deployAsset(useAjax1.ajax);
        }
    }

    const handleRefreshView = () => {
        if (!useAjax2.open) {
            refreshView(useAjax2.ajax);
        }
    }

    const handleCompileCodeDI = () => {
        if (!useAjax3.open) {
            compileCodeDI(useAjax3.ajax);
        }
    }

    const handleCheckLanguage = () => {
        if (!useAjax4.open) {
            checkLanguage(useAjax4.ajax, {
                languages: getLanguages(),
            });
        }
    }

    return (
        <SettingGroup
            title={__('Development')}
            description={__('A database is an organized collection of data, generally stored and accessed electronically from a computer system.')}
        >
            <Card>
                <CardContent>

                    <Typography style={{ marginTop: 0 }} component="h2" className='settingTitle2' variant="h4" >{__('Deploy static data')}</Typography>
                    <Typography component="p" className='settingDescription' >
                        {__('Deploy static files like HTML, CSS, JS, and images to the public file system to them usable in production mode')}
                    </Typography>
                    <Button
                        variant="contained"
                        color="primary"
                        startIcon={useAjax1.open ? <CircularProgress size={24} color={'inherit'} /> : <FileCopyIcon />}
                        className='margin'
                        onClick={() => setConfirmDialog(true)}
                    >
                        {__('Deploy')}
                    </Button>

                    <ConfirmDialog open={confirmDialog} onClose={() => { setConfirmDialog(false) }} onConfirm={() => { handleDeployAsset(); setConfirmDialog(false) }} message="Are you sure you want to synchronizing the resources" />
                    <Divider className='divider2' />

                    <Typography style={{ marginTop: 0 }} component="h2" className='settingTitle2' variant="h4" >{__('Declare hook')}</Typography>
                    <Typography component="p" className='settingDescription' >
                        {__('Automatically declare the list as well as the location to use the hooks in the system, this is necessary when adding or removing the hook\'s action from the system....')}
                    </Typography>
                    <Button
                        variant="contained"
                        color="primary"
                        startIcon={useAjax3.open ? <CircularProgress size={24} color={'inherit'} /> : <AddCircleOutlineOutlinedIcon />}
                        className='margin'
                        onClick={() => setConfirmDialog2(true)}
                    >
                        {__('Declare')}
                    </Button>
                    <ConfirmDialog open={confirmDialog2} onClose={() => { setConfirmDialog2(false) }} onConfirm={() => { handleCompileCodeDI(); setConfirmDialog2(false) }} message="Are you sure you want to Compile Code." />
                    <Divider className='divider2' />

                    <Typography component="h2" className='settingTitle2' variant="h4" >{__('Refresh views')}</Typography>
                    <Typography component="p" className='settingDescription' >
                        {__('Remove all previously compiled views to keep storefront up to date with the latest views, this is useful during development to avoid slow or no compile views')}
                    </Typography>
                    <Button
                        variant="contained"
                        color="primary"
                        startIcon={useAjax2.open ? <CircularProgress size={24} color={'inherit'} /> : <RefreshOutlinedIcon />}
                        className='margin'
                        onClick={handleRefreshView}
                    >
                        {__('Refresh')}
                    </Button>

                    <Divider className='divider2' />

                    <Typography component="h2" className='settingTitle2' variant="h4" >{__('Render language')}</Typography>
                    <Typography component="p" className='settingDescription' >
                        {__('Automatically check and add new untranslated words to the translation file, remove unused words from translation')}
                    </Typography>
                    <Button
                        variant="contained"
                        color="primary"
                        startIcon={useAjax4.open ? <CircularProgress size={24} color={'inherit'} /> : <CheckRoundedIcon />}
                        className='margin'
                        onClick={handleCheckLanguage}
                    >
                        {__('Check')}
                    </Button>

                </CardContent>
            </Card>
        </SettingGroup>
    )
}
export default Development
