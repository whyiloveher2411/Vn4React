import { Card, CardContent, Divider, Typography } from '@material-ui/core';
import Button from '@material-ui/core/Button';
import CircularProgress from '@material-ui/core/CircularProgress';
import CheckRoundedIcon from '@material-ui/icons/CheckRounded';
import CloudDownloadRoundedIcon from '@material-ui/icons/CloudDownloadRounded';
import { SettingGroup } from 'components';
import React from 'react';
import { __ } from 'utils/i18n';
import { useAjax } from 'utils/useAjax';
import { backupDatabase, checkDatabase } from './databaseAction';

function Database() {

    const useAjax1 = useAjax();
    const useAjax2 = useAjax();

    const handleCheckDatabase = () => {
        if (!useAjax1.open) {
            checkDatabase(useAjax1.ajax);
        }
    }

    const handleBackupDatabase = () => {
        if (!useAjax2.open) {
            backupDatabase(useAjax2.ajax);
        }
    }

    return (
        <SettingGroup
            title={__('Database')}
            description={__('A database is an organized collection of data, generally stored and accessed electronically from a computer system.')}
        >
            <Card>
                <CardContent>
                    <Typography style={{ marginTop: 0 }} component="h2" className='settingTitle2' variant="h4" >{__('Check Database')}</Typography>
                    <Typography component="p" className='settingDescription' >
                        {__('Check, update database structure automatically, you don\'t need to update manually like traditional methods to help limit unexpected errors')}
                    </Typography>
                    <Button
                        variant="contained"
                        color="primary"
                        startIcon={useAjax1.open ? <CircularProgress size={24} color={'inherit'} /> : <CheckRoundedIcon />}
                        className='margin'
                        onClick={handleCheckDatabase}
                    >{__('Check')}</Button>
                    <Divider className='divider2' />
                    <Typography component="h2" className='settingTitle2' variant="h4" >{__('Backup Database')}</Typography>
                    <Typography component="p" className='settingDescription' >
                        {__('Database backup is the process of backing up the operational state, architecture and stored data of database software. It enables the creation of a duplicate instance or copy of a database in case the primary database crashes, is corrupted or is lost.')}
                    </Typography>
                    <Button
                        variant="contained"
                        color="primary"
                        startIcon={useAjax2.open ? <CircularProgress size={24} color={'inherit'} /> : <CloudDownloadRoundedIcon />}
                        className='margin'
                        onClick={handleBackupDatabase}
                    >{__('Backup')}</Button>
                </CardContent>
            </Card>
        </SettingGroup>
    )
}

export default Database
