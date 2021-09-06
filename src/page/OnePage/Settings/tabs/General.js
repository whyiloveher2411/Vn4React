import { Grid } from '@material-ui/core';
import React from 'react'
import FieldForm from 'components/FieldForm';
import Timezone from '../components/Timezone';
import DateTimeFormat from '../components/DateTimeFormat';

function General({ post, data, onReview }) {
    return (
        <Grid
            container
            spacing={4}>
            <Grid item md={12} xs={12} >
                <FieldForm
                    compoment={'select'}
                    config={{
                        title: 'Status',
                        list_option: {
                            developing: { title: 'Developing' },
                            production: { title: 'Production' },
                        },
                        note: 'Some functions will be activated when the website is ready, the view will automatically minify, so please check javascript, css, html before turning on.',
                    }}
                    post={post}
                    name={'general_status'}
                    onReview={value => onReview(value, 'general_status')}
                />
            </Grid>
            <Grid item md={12} xs={12} >
                <FieldForm
                    compoment={'text'}
                    config={{
                        title: 'Site Title',
                    }}
                    post={post}
                    name={'general_site_title'}
                    onReview={value => onReview(value, 'general_site_title')}
                />
            </Grid>
            <Grid item md={12} xs={12} >
                <FieldForm
                    compoment={'text'}
                    config={{
                        title: 'Description',
                        note: 'In a few words, explain what this site is about',
                    }}
                    post={post}
                    name={'general_description'}
                    onReview={value => onReview(value, 'general_description')}
                />
            </Grid>
            <Grid item md={12} xs={12} >
                <FieldForm
                    compoment={'text'}
                    config={{
                        title: 'Email Address',
                        note: 'This address is used for admin purposes, like new user notification',
                    }}
                    post={post}
                    name={'general_email_address'}
                    onReview={value => onReview(value, 'general_email_address')}
                />
            </Grid>
            <Grid item md={12} xs={12} >
                <Timezone 
                    post={post}
                    name={'general_timezone'}
                    onReview={value => onReview(value, 'general_timezone')}
                />
            </Grid>
            <Grid item md={12} xs={12} >

                <DateTimeFormat
                    compoment={'radio'}
                    config={{
                        title: 'Date Format',
                        list_option: data.date,
                    }}
                    post={post}
                    name={'general_date_format'}
                    onReview={value => onReview(value, 'general_date_format')}
                />

            </Grid>
            <Grid item md={12} xs={12} >
                <DateTimeFormat
                    compoment={'radio'}
                    config={{
                        title: 'Time Format',
                        list_option: data.time,
                    }}
                    post={post}
                    name={'general_time_format'}
                    onReview={value => onReview(value, 'general_time_format')}
                />
            </Grid>
        </Grid>
    )
}

export default General
