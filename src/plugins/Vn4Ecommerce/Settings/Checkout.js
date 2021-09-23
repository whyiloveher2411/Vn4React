import React from 'react'
import SettingEdit1 from 'components/Setting/SettingEdit1';
import { Box } from '@material-ui/core';
import { LoadingButton } from 'components';

function Checkout({ loading }) {
    return (
        <SettingEdit1
            title="Checkout"
            titleComponent={<Box width={1} display="flex" justifyContent="space-between">
                <span>Checkout</span>
                <LoadingButton
                    className={'btn-green-save'}
                    variant="contained"
                    open={loading.open}
                >
                    Save Changes
                </LoadingButton>
            </Box>}
            backLink="/plugin/vn4-ecommerce/settings"
            description="Customize your online checkout process"
        >

        </SettingEdit1>
    )
}

export default Checkout
