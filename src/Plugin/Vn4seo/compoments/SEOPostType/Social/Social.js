import React from 'react'
import Facebook from './Facebook';
import Twitter from './Twitter';
import TwitterIcon from '@material-ui/icons/Twitter';
import FacebookIcon from '@material-ui/icons/Facebook';
import TabsCustom from 'components/TabsCustom';

function Social({ data, onReview }) {
    return (
        <TabsCustom
            tabIcon={true}
            name="vn4seo_createdata_share"
            tabs={[
                { title: <FacebookIcon />, content: () => <Facebook data={data} onReview={onReview} /> },
                { title: <TwitterIcon />, color: 'rgb(29, 161, 242)', content: () => <Twitter data={data} onReview={onReview} /> }
            ]}
        />
    )
}

export default Social
