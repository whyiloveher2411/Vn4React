import { Card, CardContent, Divider, Typography } from '@material-ui/core';
import Button from '@material-ui/core/Button';
import CircularProgress from '@material-ui/core/CircularProgress';
import CheckRoundedIcon from '@material-ui/icons/CheckRounded';
import CloudDownloadRoundedIcon from '@material-ui/icons/CloudDownloadRounded';
import { SettingGroup } from 'components';
import React from 'react';
import { useAjax } from 'utils/useAjax';

function Database() {

    const useAjax1 = useAjax();
    const useAjax2 = useAjax();
    
    const checkDatabase = () => {

        // showNotification('The database is being prepared, we will notify you once completed.', 'default');
        if (!useAjax1.open) {
            useAjax1.ajax({
                url: 'tool/database-check',
                method: 'POST',
                isGetData: false,
                success: (result) => {

                }
            });
        }
    }

    const backupDatabase = () => {
        if (!useAjax2.open) {
            useAjax2.ajax({
                url: 'tool/database-backup',
                method: 'POST',
                isGetData: false,
                success: (result) => {

                }
            });
        }
    }

    return (
        <SettingGroup
            title="Database"
            description="A database is an organized collection of data, generally stored and accessed electronically from a computer system."
        >
            <Card>
                <CardContent>
                    <Typography style={{ marginTop: 0 }} component="h2" className='settingTitle2' variant="h4" >Check</Typography>
                    <Typography component="p" className='settingDescription' >
                        When you create a new post type but you do not have time to optimize the DB as well as check if the database is already on the floor
                    </Typography>
                    <Button
                        variant="contained"
                        color="primary"
                        startIcon={useAjax1.open ? <CircularProgress size={24} color={'inherit'} /> : <CheckRoundedIcon />}
                        className='margin'
                        onClick={checkDatabase}
                    >Check</Button>
                    <Divider className='divider2' />
                    <Typography component="h2" className='settingTitle2' variant="h4" >Backup</Typography>
                    <Typography component="p" className='settingDescription' >
                        Database backup is the process of backing up the operational state, architecture and stored data of database software. It enables the creation of a duplicate instance or copy of a database in case the primary database crashes, is corrupted or is lost.
                    </Typography>
                    <Button
                        variant="contained"
                        color="primary"
                        startIcon={useAjax2.open ? <CircularProgress size={24} color={'inherit'} /> : <CloudDownloadRoundedIcon />}
                        className='margin'
                        onClick={backupDatabase}
                    >Backup</Button>
                </CardContent>
            </Card>
        </SettingGroup>
    )
}

export default Database
