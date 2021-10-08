import { Card, CardContent, Typography } from '@material-ui/core';
import { Skeleton } from '@material-ui/lab';
import { FieldForm } from 'components';
import React from 'react';
import { __ } from 'utils/i18n';

function Menu({ listMenu, changeMenuEdit, listPostType }) {

    if (!listPostType || !listMenu.list_option) {
        return (
            <Card>
                <CardContent>
                    <Skeleton style={{ margin: '10px 0', transform: 'scale(1, 1)' }} animation="wave" height={32} />
                </CardContent>
            </Card>
        );
    }

    return (
        <>
            <Card>
                <CardContent>
                    <div style={{ display: 'flex', whiteSpace: 'nowrap', alignItems: 'center' }}>
                        <Typography>{__('Select menu to edit:')}</Typography>
                        &nbsp;
                        <div style={{ width: 280 }}>
                            <FieldForm
                                compoment='select'
                                config={{
                                    title: __('Menu'),
                                    list_option: listMenu.list_option,
                                    size: 'small',
                                    disableAlert: true,
                                    inputProps: {
                                        disableClearable: true
                                    }
                                }}
                                post={{ menuItem: listMenu.value }}
                                size="small"
                                name='menuItem'
                                onReview={(value) => { changeMenuEdit(value); }}
                            />
                        </div>
                    </div>
                </CardContent>
            </Card>
        </>
    )
}

export default Menu
