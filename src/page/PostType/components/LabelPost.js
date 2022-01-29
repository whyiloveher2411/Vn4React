import { makeStyles } from '@material-ui/core'
import React from 'react'
import { default as LabelTab } from '../../../components/Label'


const useStyles = makeStyles(() => ({
    root: {
        marginLeft: 4,
        borderRadius: 20,
    },
}))

function LabelPost({ post }) {

    const classes = useStyles()

    const showMoreInformation = (post) => {

        if (!post) return [];

        let result = [];

        if (post.visibility === 'private') {
            result.push({ title: 'Private', color: '#8604c4' });
        }

        if (post.password && post.visibility === 'password') {
            result.push({ title: 'Password protected', color: '#00851d' });
        }

        if (post.post_date_gmt) {
            result.push({ title: 'Schedule', color: '#0079be' });
        }

        switch (post.status) {
            case 'publish':
                result.push({ title: 'Publish', color: '#43a047' });
                break;
            case 'draft':
                result.push({ title: 'Drafts', color: '#757575' });
                break;
            case 'trash':
                result.push({ title: 'Trash', color: '#e53935' });
                break;
            case 'pending':
                result.push({ title: 'Pending', color: '#f68924' });
                break;
            default:
                break;
        }
       
        return result;
    }

    return (
        showMoreInformation(post).map((info, index) => (
            <LabelTab color={info.color} className={classes.root} key={index}>{info.title}</LabelTab>
        ))
    )
}

export default LabelPost
