import { makeStyles } from '@material-ui/styles'
import { Typography, Divider, colors, Grid, Card, CardContent, CardHeader } from '@material-ui/core'
import React from 'react'
import { Page } from '../../components'
import FieldForm from 'components/FieldForm';

const FieldList = [
    'input', 'email', 'number', 'textarea', 'radio', 'checkbox', 'select', 'date_picker', 'image', 'asset-file', 'color', 'editor',
    'flexible', 'group', 'group-type', 'json', 'link', 'menu', 'password', 'relationship_manytomany', 'relationship_manytomany_show', 'relationship_onetomany', 'relationship_onetomany_show', 'relationship_onetoone', 'relationship_onetoone_show', 'repeater', 'slug', 'text', 'true_false',
];

const useStyles = makeStyles((theme) => ({
    root: {
        padding: theme.spacing(3, 3, 6, 3),
    },
    divider: {
        backgroundColor: colors.grey[300],
        marginTop: theme.spacing(1),
        marginBottom: theme.spacing(3),
    },
    markdownContainer: {
        maxWidth: 700,
    },
}))

function ShowListInputField() {

    const classes = useStyles();

    return (
        <Page title="Input Fields">
            <Typography>Development</Typography>
            <Typography variant="h3">Fields are used throughout the system</Typography>
            <Divider className={classes.divider} />
            <form autoComplete="off">
                <Card>
                    <CardHeader title="All Fields" />
                    <Divider />
                    <CardContent>
                        <Grid
                            container
                            spacing={4}>

                            {
                                FieldList.map(field => (
                                    <Grid item md={6} xs={12} >
                                        <h3>{field}</h3>
                                        <FieldForm
                                            compoment={field}
                                            config={{ title: field }}
                                            post={{}}
                                            name={field}
                                            onReview={(value, key2 = field) => { }}
                                        />
                                    </Grid>
                                ))
                            }
                        </Grid>
                    </CardContent>
                </Card>
            </form>
        </Page>
    )
}

export default ShowListInputField
