import express from "express";
import { data } from "../data/data.js";
import { syncData } from "../data/sync.js";

const router = express.Router();

router.get("/", (req, res) => {
  res.json(data.services);
});

router.post("/", (req, res) => {
  const { name, type } = req.body;
  const id = data.services.length + 1;

  data.services.push({ id, name, type, slots: [] });
  syncData();

  res.json({ status: "ok", id });
});

export default router;
