import React from 'react'
import SettingEdit1 from 'components/Setting/SettingEdit1';
import { Box } from '@material-ui/core';
import { LoadingButton } from 'components';

function Shipping({ loading }) {
    return (
        <SettingEdit1
            title="Shipping and delivery"
            titleComponent={<Box width={1} display="flex" justifyContent="space-between">
                <span>Shipping and delivery</span>
                <LoadingButton
                    className={'btn-green-save'}
                    variant="contained"
                    open={loading.open}
                >
                    Save Changes
                </LoadingButton>
            </Box>}
            backLink="/plugin/vn4-ecommerce/settings"
            description="Manage how you ship orders to customers"
        >

        </SettingEdit1>
    )
}

export default Shipping
