import React from 'react'
import SettingEdit1 from 'components/Setting/SettingEdit1';
import { Box } from '@material-ui/core';
import { LoadingButton } from 'components';

function Notifications({ loading }) {
    return (
        <SettingEdit1
            title="Notifications"
            titleComponent={<Box width={1} display="flex" justifyContent="space-between">
                <span>Notifications</span>
                <LoadingButton
                    className={'btn-green-save'}
                    variant="contained"
                    open={loading.open}
                >
                    Save Changes
                </LoadingButton>
            </Box>}
            backLink="/plugin/vn4-ecommerce/settings"
            description="Manage notifications sent to you and your customers"
        >

        </SettingEdit1>
    )
}

export default Notifications

