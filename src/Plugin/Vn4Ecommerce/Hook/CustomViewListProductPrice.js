import React from 'react'

function CustomViewListProductPrice(props) {

    if (props.post.sale_price) {
        return (
            <div>
                <span style={{ color: 'green', fontWeight: 'bold' }}>${props.post.sale_price}</span> - <del style={{ textDecoration: 'line-through', color: 'red' }}>${props.post.price}</del>
            </div>
        )
    }

    if( props.post.price ){
        return (
            <div>
                <span style={{ color: 'green', fontWeight: 'bold' }}>${props.post.price}</span>
            </div>
        )
    }

    return null;
}

export default CustomViewListProductPrice
