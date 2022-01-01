import { Box, makeStyles, Typography } from '@material-ui/core';
import { TabsCustom } from 'components';
import { PageHeaderSticky } from 'components/Page';
import RedirectWithMessage from 'components/RedirectWithMessage';
import React from 'react';
import { Redirect, useHistory, useRouteMatch } from 'react-router-dom';
import { __ } from 'utils/i18n';
import { usePermission } from 'utils/user';
import ListNewMenu from './components/Menu/ListNewMenu';
import Structure from './components/Menu/Structure';


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

    const permission = usePermission('menu_management').menu_management;

    const history = useHistory();
    const match = useRouteMatch();

    const { subtab1 } = match.params;

    const tabs = [
        {
            title: __('Menus'),
            value: 'list',
            content: () => <ListNewMenu />
        },
        {
            title: __('Structure'),
            value: 'structure',
            content: () => <Structure />
        }
    ];

    const handleTabsChange = (index) => {
        history.push('/appearance/menu/' + tabs[index].value);
    }

    if (!permission) {
        return <RedirectWithMessage />
    }

    if (!subtab1 || !tabs.find(t => t.value === subtab1)) {
        return <Redirect to={'/appearance/menu/' + tabs[0].value} />;
        // return <Redirect to="/errors/error-404" />;
    }

    return (
        <PageHeaderSticky
            title={__('Menu')}
            header={
                <>
                    <Typography component="h2" gutterBottom variant="overline">
                        {__('Appearance')}
                    </Typography>
                    <Typography component="h1" variant="h3">
                        {__('Menu')}
                    </Typography>
                </>
            }
        >
            <Box style={{ marginTop: 24 }} className={classes.root}>
                <TabsCustom
                    name="menu"
                    tabs={tabs}
                    tabIndex={tabs.findIndex(item => item.value === subtab1)}
                    onChangeTab={handleTabsChange}
                />
            </Box>
        </PageHeaderSticky>
    )
}

export default Menu
