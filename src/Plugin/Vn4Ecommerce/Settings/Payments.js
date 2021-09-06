import React from 'react'
import SettingEdit1 from 'components/Setting/SettingEdit1';
import { Box } from '@material-ui/core';
import { LoadingButton } from 'components';

function Payments({ loading }) {
    return (
        <SettingEdit1
            title="Payments"
            titleComponent={<Box width={1} display="flex" justifyContent="space-between">
                <span>Payments</span>
                <LoadingButton
                    className={'btn-green-save'}
                    variant="contained"
                    open={loading.open}
                >
                    Save Changes
                </LoadingButton>
            </Box>}
            backLink="/plugin/vn4-ecommerce/settings"
            description="Enable and manage your store's payment providers"
        >

        </SettingEdit1>
    )
}

export default Payments
