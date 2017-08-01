const api_admin_index = "/api/admin"
const admin_index = "/admin"

const api_farmer_index = "/api/farmer";
const farmer_index = "/farmer";

const api_buyer_index = "/api/buyer";
const buyer_index = "/buyer";

export default {
    api: {
        admin: {
            farmer: api_admin_index + "/farmer",
        },
        farmer: {
            index: api_farmer_index,
            plant: api_farmer_index + "/plant",
            order: api_farmer_index + "/order",
        },
        buyer: {
            index: api_buyer_index,
            order: api_buyer_index + "/order",
            openBuySellOrder: api_buyer_index + "/order/openWithConfirm",
            confirmOrder: api_buyer_index + 'confirm-order',
            plant: api_buyer_index + "/plant",
            farmer: api_buyer_index + "/farmer",
            farmerPlant: api_buyer_index + "/farmer/plant",
            plan: api_buyer_index + "/plan",

        },
    },
    web: {
        admin: {
            farmer: {
                index: admin_index + "/farmers",
                create: admin_index + "/farmers/create",
            }
        },
        farmer: {
            index: farmer_index,
            edit: farmer_index + "/edit",
            plant: farmer_index + "/plant",
        },
        buyer: {
            index: buyer_index,
            order: buyer_index + "/order",
            plant: buyer_index + "/plant",
            plan : buyer_index + "/plan",
            farmer: {
                index: buyer_index + "/farmer",
                create: buyer_index + "/farmer/create",
            }
        },
    }
}

