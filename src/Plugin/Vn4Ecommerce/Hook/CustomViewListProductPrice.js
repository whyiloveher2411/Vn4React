import React from 'react'

function CustomViewListProductPrice(props) {

    return (
        <div>
            {
                Boolean(props.post.compare_price) &&
                <>
                    <del style={{ textDecoration: 'line-through', color: 'red' }}>${new Intl.NumberFormat().format(props.post.compare_price)}</del> - 
                </>
            }
            <span style={{ color: 'green', fontWeight: 'bold' }}> ${new Intl.NumberFormat().format(props.post.price)}</span>
        </div>
    )
}

export default CustomViewListProductPrice
