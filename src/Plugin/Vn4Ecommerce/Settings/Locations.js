import React from 'react'
import SettingEdit1 from 'components/Setting/SettingEdit1';
import { Box } from '@material-ui/core';
import { LoadingButton } from 'components';

function Locations({ loading }) {
    return (
        <SettingEdit1
            title="Locations"
            titleComponent={<Box width={1} display="flex" justifyContent="space-between">
                <span>Locations</span>
                <LoadingButton
                    className={'btn-green-save'}
                    variant="contained"
                    open={loading.open}
                >
                    Save Changes
                </LoadingButton>
            </Box>}
            backLink="/plugin/vn4-ecommerce/settings"
            description="Manage the places you stock inventory, fulfill orders, and sell products"
        >

        </SettingEdit1>
    )
}

export default Locations
