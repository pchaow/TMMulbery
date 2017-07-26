const api_farmer_index = "/api/farmer";
const farmer_index = "/farmer";

const api_buyer_index = "/api/buyer";
const buyer_index = "/buyer";

export default {
    api: {
        admin: {},
        farmer: {
            index: api_farmer_index,
            plant: api_farmer_index + "/plant",
            order: api_farmer_index + "/order",
        },
        buyer: {
            index: api_buyer_index,
            order: api_buyer_index + "/order",
            loadSellOpenOrderUrl: api_buyer_index + "/loadSellOpenOrder",
            plant: api_buyer_index + "/plant",
        },
    },
    web: {
        admin: {},
        farmer: {
            index: farmer_index,
            edit: farmer_index + "/edit",
            plant: farmer_index + "/plant",
        },
        buyer: {
            index: buyer_index,
            order: buyer_index + "/order",
            plant: buyer_index + "/plant",
        },
    }
}

