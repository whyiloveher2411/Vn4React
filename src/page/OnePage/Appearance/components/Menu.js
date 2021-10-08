import { Box, makeStyles } from '@material-ui/core';
import { TabsCustom } from 'components';
import RedirectWithMessage from 'components/RedirectWithMessage';
import React from 'react';
import { __ } from 'utils/i18n';
import { checkPermission } from 'utils/user';
import ListNewMenu from '../components/Menu/ListNewMenu';
import Structure from '../components/Menu/Structure';


const useStyles = makeStyles((theme) => ({
    root: {
        '& .btn-save-changes': {
            color: theme.palette.buttonSave.contrastText,
            backgroundColor: theme.palette.buttonSave.main,
            '&:hover': {
                backgroundColor: theme.palette.buttonSave.dark,
            }
        },
        '& .color-remove:hover': {
            color: theme.palette.secondary.dark,
        }
    },
}));

function Menu() {

    const classes = useStyles();

    const permission = checkPermission('menu_management');

    if (!permission) {
        return <RedirectWithMessage />
    }

    return (
        <Box style={{ marginTop: 24 }} className={classes.root}>
            <TabsCustom
                name="menu"
                tabs={[
                    {
                        title: __('Menus'), content: () => <ListNewMenu />
                    },
                    {
                        title: __('Structure'), content: () => <Structure />
                    }
                ]}
            />
        </Box>
    )
}

export default Menu
